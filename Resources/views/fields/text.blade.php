<input type="text"
    class="form-control"
    name="{{ array_get($options, 'name', []) }}"
    placeholder="{{ array_get($options, 'options.placeholder', null) }}"
    value="{{ $value or null }}"
>
