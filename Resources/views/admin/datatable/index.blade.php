@if( ($alert = array_get($tableConfig, 'page.alert', false)) !== false )
    <div class="alert alert-{{ $alert['class'] }}">{!! $alert['text'] !!}</div>
@endif

{!! Datatable::table()
     ->addColumn($columns)
     ->setUrl(route(array_get($tableConfig, 'options.source', false)))
     ->setOptions('sPaginationType', 'bootstrap')
     ->render(partial('admin::admin.datatable.table')) !!}
