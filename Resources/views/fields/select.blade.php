@set($name, array_get($options, 'name', []))

<label for="radio-{{ str_slug($name) }}">
    <select
        id="radio-{{ str_slug($name) }}"
        name="{{ $name }}"
        {{ array_get($options, 'options.multiple', false) == true ? 'multiple' : null }}
    >
    @foreach (array_get($options, 'options.options', []) as $key => $value)
        @set($value, $value ? array_get($value, 'value') : 0)
        <option
            value="{{ $value }}"
            {{ $value == array_get($options, 'value') ? ' selected="selected"' : null }}
        >{{ $key }}</option>
    @endforeach
    </select>
</label>
