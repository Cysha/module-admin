@extends(partial('admin::admin.config._form'))

@section('admin-form')
    <div class="alert alert-warning"><strong>Warning:</strong> This panel is still WIP and might not work 100%, if at all.</div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Maintenance</h3>
        </div>
        <div class="panel-body">
            {!! Form::Config('cms.core.app.maintenance', 'radio')->radios(['Yes' => ['value' => 'true'], 'No' => ['value' => 'false']])->label('Enable?')->inline() !!}
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Debug</h3>
        </div>
        <div class="panel-body">
            {!! Form::Config('cms.core.app.debug', 'radio')->radios(['Yes' => ['value' => 'true'], 'No' => ['value' => 'false']])->label('Enable?')->inline() !!}
        </div>
    </div>
@stop
