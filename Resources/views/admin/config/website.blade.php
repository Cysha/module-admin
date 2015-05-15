@extends(partial('admin::admin.config._layout'))

@section('admin-config')
{!! Former::horizontal_open(route('admin.config.store')) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Website</h3>
        </div>
        <div class="panel-body">
            {!! Form::Config('cms.core.app.site-name')->label('Site Name') !!}
            {!! Form::Config('app.timezone', 'select')->options($timezones)->label('Timezone') !!}
            {!! Form::Config('cms.core.app.pxcms-index', 'select')->options($indexRoutes)->label('Set Homepage') !!}
            {!! Form::Config('cms.core.app.force-secure', 'radio')->radios(['Yes' => ['value' => 'true'], 'No' => ['value' => 'false']])->label('Force HTTPS?') !!}
        </div>
    </div>

    <button class="btn-labeled btn btn-success pull-right" type="submit">
        <span class="btn-label"><i class="glyphicon glyphicon-ok"></i></span> Save
    </button>
{!! Former::close() !!}
@stop
