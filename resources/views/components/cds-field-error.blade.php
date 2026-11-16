@props(['name'])
@error($name)
    <p class="cds-error-msg" id="{{ str_replace(['[', ']', '.'], ['-', '', '-'], $name) }}-error">
        <span class="material-symbols-outlined" style="font-size:16px">error</span>
        <span>{{ $message }}</span>
    </p>
@enderror
