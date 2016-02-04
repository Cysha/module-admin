@extends(partial('admin::admin.config._layout'))

@section('admin-config')
{!! Former::horizontal_open(route('admin.config.store')) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Website</h3>
        </div>
        <div class="panel-body">
            {!! Form::Config('cms.core.app.site-name')->label('Site Name') !!}
            {!! Form::Config('cms.core.app.timezone', 'select')->options($timezones)->label('Timezone') !!}
            {!! Form::Config('cms.core.app.pxcms-index', 'select')->options($indexRoutes)->label('Set Homepage') !!}
            {!! Form::Config('cms.core.app.force-secure', 'radio')->radios(['Yes' => ['value' => 'true'], 'No' => ['value' => 'false']])->label('Force HTTPS?')->inline() !!}
            {!! Form::Config('cms.core.app.minify-html', 'radio')->radios(['Yes' => ['value' => 'true'], 'No' => ['value' => 'false']])->label('Minify HTML?')->inline()->disabled((app()->environment() === 'local'))->inlineHelp(app()->environment() === 'local' ? '<i class="fa fa-warning"></i> Disabled due to being on a local environment' : '') !!}
        </div>
    </div>

    <button class="btn-labeled btn btn-success pull-right" type="submit">
        <span class="btn-label"><i class="glyphicon glyphicon-ok"></i></span> Save
    </button>
{!! Former::close() !!}
@stop
