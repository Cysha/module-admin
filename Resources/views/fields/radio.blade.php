@set($counter, 0)

<ul class="radio">
@foreach (array_get($options, 'options.options', []) as $key => $value)
    @set($value, $value ? array_get($value, 'value') : 0)
    <li>
        <label for="radio-{{ str_slug($key) }}-{{ $counter }}">
            <input type="radio"
                id="radio-{{ str_slug($key) }}-{{ $counter }}"
                name="{{ array_get($options, 'name', []) }}"
                value="{{ $value }}"
                {{ $value == array_get($options, 'value') ? ' checked="checked"' : null }}
            >
            <span>{{ $key }}</span>
        </label>
    </li>
@set($counter, $counter+1)
@endforeach
</ul>
