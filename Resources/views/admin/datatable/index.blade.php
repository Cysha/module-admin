@if(($alert = array_get($tableConfig, 'page.alert', false)) !== false)
    <div class="alert alert-{{ $alert['class'] }}">{!! $alert['text'] !!}</div>
@endif

@set($id, str_random(6))

<table id="{{ $id }}" class="table dataTable table-striped table-bordered">
    <colgroup>
    @foreach($columns as $key => $col)
        <col class="col {{ str_slug($key) }}" width="{{ array_get($col, 'width') }}" />
    @endforeach
    </colgroup>
    <thead>
        <tr>
        @foreach($columns as $key => $col)
            <th class="head {{ str_slug('th_'.$key) }} {{ array_get($col, 'th-class', null) }}">
                {{ $col['th'] }}
            </th>
        @endforeach
        </tr>
    </thead>
    @if(array_get($tableConfig, 'options.tfoot', false) !== false)
    <tfoot>
        <tr class="info">
        @foreach($columns as $key => $col)
            <th class="head {{ str_slug('th_'.$key) }} {{ array_get($col, 'th-class', null) }}">
                {{ $col['th'] }}
            </th>
        @endforeach
        </tr>
    </tfoot>
    @endif

    <tbody>

    </tbody>
</table>

{!! \Debug::dump($tableOptions, ''); !!}
<script>
jQuery.extend(jQuery.fn.dataTable.defaults, {!! $options !!});

jQuery(window).load(function () {
    jQuery('#{{ $id }}').dataTable();
});
</script>
