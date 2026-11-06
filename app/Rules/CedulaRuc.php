<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Valida una identificación ecuatoriana:
 * - Cédula: 10 dígitos (persona natural, 3er dígito < 6)
 * - RUC:    13 dígitos, provincia válida y establecimiento (3 últimos dígitos) distinto de 000
 */
class CedulaRuc implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!self::esValida((string) $value)) {
            $fail('El número de cédula (10 dígitos) o RUC (13 dígitos) no es válido.');
        }
    }

    public static function esValida(string $numero): bool
    {
        $len = strlen($numero);
        if (!ctype_digit($numero) || ($len !== 10 && $len !== 13)) {
            return false;
        }

        // 01-24 provincias, 30 = ecuatorianos registrados en el exterior
        $provincia = (int) substr($numero, 0, 2);
        if (!(($provincia >= 1 && $provincia <= 24) || $provincia === 30)) {
            return false;
        }

        if ($len === 10) {
            // Cédula: persona natural, dígito verificador módulo 10
            return (int) $numero[2] < 6 && self::verificadorModulo10($numero);
        }

        // RUC: no se valida dígito verificador porque el SRI ha emitido RUC
        // (sobre todo de sociedades) que no cumplen el algoritmo módulo 11.
        return substr($numero, 10, 3) !== '000';
    }

    public static function esRuc(?string $numero): bool
    {
        return strlen((string) $numero) === 13;
    }

    private static function verificadorModulo10(string $numero): bool
    {
        $coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];
        $suma = 0;
        for ($i = 0; $i < 9; $i++) {
            $valor = (int) $numero[$i] * $coeficientes[$i];
            $suma += $valor >= 10 ? $valor - 9 : $valor;
        }
        $verificador = ($suma % 10 === 0) ? 0 : 10 - ($suma % 10);

        return $verificador === (int) $numero[9];
    }
}
