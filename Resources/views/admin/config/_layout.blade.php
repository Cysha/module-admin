<div class="row">
    <div class="col-md-{{ $col_one or '3'}}">
        <div class="panel panel-default">
            <div class="panel-heading">Config</div>
            <div class="panel-body">@menu('backend_config_menu')</div>
        </div>
    </div>
    <div class="col-md-{{ $col_two or '9'}}">
        @yield('admin-config')
    </div>
</div>
