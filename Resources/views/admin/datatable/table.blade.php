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

<script type="text/javascript">
tableOptions = {
    "bStateSave": true,
    "bFilter": {{ (array_get($tableConfig, 'options.filtering', false) === true ? 'true' : 'false') }},
    "bSort": {{ (array_get($tableConfig, 'options.sorting', false) === true ? 'true' : 'false') }},
    "bPaginate": {{ (array_get($tableConfig, 'options.pagination', false) === true ? 'true' : 'false') }},
    "bAutoWidth": false,
    "fnDrawCallback": function (oSettings) {
        if (window.onDatatableReady) {
            window.onDatatableReady();
        }
    }
};

jQuery(window).load(function () {
    jQuery('table.dataTable').dataTable(jQuery.extend(tableOptions, {!! $options !!}));
});
</script>
