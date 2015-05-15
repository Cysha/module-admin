@extends(partial('admin::admin.config._layout'))

@section('admin-config')
{!! Former::horizontal_open(route('admin.config.store')) !!}
    @yield('admin-form')

    <button class="btn-labeled btn btn-success pull-right" type="submit">
        <span class="btn-label"><i class="glyphicon glyphicon-ok"></i></span> Save
    </button>
{!! Former::close() !!}
@stop
