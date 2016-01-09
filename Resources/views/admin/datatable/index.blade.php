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
            <th class="head {{ str_slug('th_'.$key) }} {{ array_get($col, 'th-class', null) }}" data-search="{{ array_get($col, 'searchable', false) === true ? 'true' : 'false' }}">
                {!! $col['th'] !!}
            </th>
        @endforeach
        </tr>
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

<script>
var options = {!! $options !!};

@if(array_get($tableConfig, 'options.column_search', false) === true)
    options['initComplete'] = function () {
        this.api().columns().every(function () {
            var column = jQuery('#{{ $id }} thead th').eq(this.index());

            var title = jQuery(column).text().trim();
            if (title == 'Actions' || column.data('search') === false) {
                jQuery(this.footer()).empty();
                return;
            }

            var input = jQuery('<input />').attr({'type': 'text', 'placeholder': 'Search '+title});

            var column = this;
            jQuery(input).appendTo(jQuery(this.footer()).empty()).on('change', function () {
                var val = jQuery.fn.dataTable.util.escapeRegex(jQuery(this).val());

                column
                    .search(val ? val : '', false, false)
                    .draw();
            });
        });
    };
@endif

jQuery.extend(jQuery.fn.dataTable.defaults, options);
var datatable = jQuery('#{{ $id }}').DataTable();
</script>
