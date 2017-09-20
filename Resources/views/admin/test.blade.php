
@foreach(config('cms.admin.fieldTypes') as $options)
<div class="row">
    <h4>{{ array_get($options, 'name') }}</h4>

    <div class="col-md-6">
        @include(array_get($options, 'view'), compact('options'))
    </div>
    <div class="col-md-6">
        <pre>{{ json_encode(array_get($options, 'view'), JSON_PRETTY_PRINT) }}</pre>
        <pre>{{ json_encode(array_get($options, 'options', []), JSON_PRETTY_PRINT) }}</pre>
    </div>
</div>
@endforeach
