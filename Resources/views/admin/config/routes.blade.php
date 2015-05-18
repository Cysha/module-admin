@extends(partial('admin::admin.config._layout'))

@section('admin-config')
{!! Former::horizontal_open(route('admin.config.store')) !!}
    <div class="alert alert-warning"><strong>Warning:</strong> This panel is still WIP and might not work 100%, if at all.</div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Routes <small>(Make sure paths have the trailing slash)</small></h3>
        </div>
        <table class="panel-body table table-striped">
            <thead>
                <tr>
                    <th>Route</th>
                    <th>Value</th>
            </thead>
            <tbody>
                <tr>
                    <td>API Path</td>
                    <td>{!! Form::Config('api.prefix')->label(false) !!}</td>
                </tr>
                <tr>
                    <td>Frontend Path</td>
                    <td>{!! Form::Config('cms.core.app.paths.frontend')->label(false) !!}</td>
                </tr>
                <tr>
                    <td>Backend Path</td>
                    <td>{!! Form::Config('cms.core.app.paths.backend')->label(false) !!}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <button class="btn-labeled btn btn-success pull-right" type="submit">
        <span class="btn-label"><i class="glyphicon glyphicon-ok"></i></span> Save
    </button>
{!! Former::close() !!}
@stop
