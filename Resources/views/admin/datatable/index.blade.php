@if(($alert = array_get($tableConfig, 'page.alert', false)) !== false)
    <div class="alert alert-{{ $alert['class'] }}">{!! $alert['text'] !!}</div>
@endif

@set($id, str_random(6))
<form name="datatable-form" action="#" method="POST">
<table id="{{ $id }}" class="table dataTable table-striped table-bordered">
    <colgroup>
    @foreach($columns as $key => $col)
        <col class="col {{ str_slug($key) }}" width="{{ array_get($col, 'width') }}" />
    @endforeach
    </colgroup>
    <thead>
        <tr>
        @foreach($columns as $key => $col)
            <th class="head {{ str_slug('th_'.$key) }} {{ array_get($col, 'th-class', null) }}"
                data-search="{{ array_get($col, 'searchable', false) === true ? 'true' : 'false' }}">

                {!! $col['th'] !!}
            </th>
        @endforeach
        </tr>
        @if(array_get($tableConfig, 'options.column_search', false) === true)
        <tr>
        @foreach($columns as $key => $col)
            <td>
                @if ($key === 'actions')
                <input type="submit"  class="form-control" value="Search">
                @endif

                @if (array_get($col, 'searchable', false))
                <input type="text" class="form-control" onclick="stopPropagation(event);"  name="{{ $key }}" id="{{ $key }}">
                @else
                &nbsp;
                @endif
            </td>
        @endforeach
        </tr>
        @endif
    </thead>
    @if(array_get($tableOptions, 'tfoot', false) === true)
    <tfoot>
        <tr class="info">
        @foreach($columns as $key => $col)
            <th class="head {{ str_slug('th_'.$key) }} {{ array_get($col, 'th-class', null) }}">
                {!! $col['th'] !!}
            </th>
        @endforeach
        </tr>
    </tfoot>
    @endif

    <tbody>

    </tbody>
</table>
</form>
<script>
var options = {!! $options !!};
options.orderCellsTop = true;
jQuery.extend(jQuery.fn.dataTable.defaults, options);

@if(array_get($tableConfig, 'options.column_search', false) === true)

options.ajax.data = function (d) {
@foreach($columns as $key => $col)
@continue(!array_get($col, 'searchable', false))
d.{{ $key }} = jQuery('input[name={{ $key }}]').val();
@endforeach
}

jQuery.extend(jQuery.fn.dataTable.defaults, {
    searching: false
});
@endif

var datatable = jQuery('#{{ $id }}').DataTable();
@if(array_get($tableConfig, 'options.column_search', false) === true)
jQuery('form[name=datatable-form]').submit(function(e) {
    datatable.draw();
    e.preventDefault();
});
@endif

function stopPropagation(evt) {
    if (evt.stopPropagation !== undefined) {
        evt.stopPropagation();
    } else {
        evt.cancelBubble = true;
    }
}
</script>
