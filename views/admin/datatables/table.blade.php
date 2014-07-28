<?php //echo \Debug::dump([$options, $callbacks, $values, $data, $columns, $noScript, $id, $class], ''); ?>
<table class="table table-striped table-bordered {{ $class = str_random(8) }}">
    <colgroup>
    @foreach($columns as $key => $col)
        <col class="col {{ $key }}" width="{{ array_get($col, 'width')}}"  />
    @endforeach
    </colgroup>
    <thead>
        <tr>
        @foreach($columns as $key => $col)
            <th class="head {{ $key }}">
                {{ $col['th'] }}
            </th>
        @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($data as $row)
        <tr>
            @foreach($row as $cell)
            <td>{{ $cell }}</td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>

<script type="text/javascript">
jQuery(function () {
    jQuery.extend( jQuery.fn.dataTable.defaults, {
        "bSearching": false,
        "bOrdering": false
    } );

    jQuery('.{{ $class }}').dataTable({
       "bAutoWidth": false,
       @foreach ($options as $k => $o) {{ json_encode($k) }}: {{ json_encode($o) }},
       @endforeach
       @foreach ($callbacks as $k => $o) {{ json_encode($k) }}: {{ $o }},
       @endforeach

       "fnDrawCallback": function (oSettings) {
           if (window.onDatatableReady) {
               window.onDatatableReady();
           }
       }
    });
});
</script>
