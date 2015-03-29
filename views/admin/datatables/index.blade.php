@if( ($alert = array_get($options, 'alert', false)) !== false )
    <div class="alert alert-{{ $alert['class'] }}">{{ $alert['text'] }}</div>
@endif

{{ Datatable::table()
 ->addColumn($columns)
 ->setUrl(array_get($options, 'source', false))
 ->setOptions('sPaginationType', 'bootstrap')
 ->render(partial('admin::admin.datatables.table')) }}
