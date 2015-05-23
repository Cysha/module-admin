@extends(partial('admin::admin.config._layout'))

@section('admin-config')
{!! Former::horizontal_open(route('admin.config.store')) !!}
    <div class="alert alert-info"><strong>Warning:</strong> This panel will allow you to configure API Keys for the services that require them.</div>

    @foreach(config('cms.admin.admin.services_views') as $view)
        @include(partial($view))
    @endforeach

    <button class="btn-labeled btn btn-success pull-right" type="submit">
        <span class="btn-label"><i class="glyphicon glyphicon-ok"></i></span> Save
    </button>
{!! Former::close() !!}
@stop
