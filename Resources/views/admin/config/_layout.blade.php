<div class="row">
    <div class="col-md-{{ $col_one or '3'}}">
        @menu('acp.config_menu')
    </div>
    <div class="col-md-{{ $col_two or '9'}}">
        @yield('admin-config')
    </div>
</div>
