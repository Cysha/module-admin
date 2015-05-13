@extends(partial('admin::admin.config._layout'))

@section('admin-config')
    {!! Former::horizontal_open(route('admin.config.store')) !!}
        {!! Form::Config('cms.core.app.site-name')->label('Site Name') !!}

        {!! Form::Config('cms.core.app.pxcms-index', 'select')->options($indexRoutes)->label('Set Homepage') !!}

        {!! Form::Config('cms.core.app.google-analytics')->label('Google Analytics Code') !!}

        {!! Form::Config('cms.core.app.force-secure', 'radio')->radios(['Yes' => ['value' => 'true'], 'No' => ['value' => 'false']])->label('Force HTTPS?') !!}

        {!! Form::Config('cms.core.app.debug', 'radio')->radios(['Yes' => ['value' => 'true'], 'No' => ['value' => 'false']])->label('Enable Debug?') !!}


        <button class="btn-labeled btn btn-success pull-right" type="submit">
            <span class="btn-label"><i class="glyphicon glyphicon-ok"></i></span> Save
        </button>

    {!! Former::close() !!}
@stop
