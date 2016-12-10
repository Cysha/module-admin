{!! Former::horizontal_open() !!}
<div class="col-md-9">
    <div class="alert alert-warning"><strong>Warning:</strong> This panel is still WIP and might not work 100%, if at all.</div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Navigation Link</h3>
        </div>
        <div class="panel-body">
            {!! Former::text('title') !!}
            {!! Former::text('class')->label('Link Class') !!}
            {!! Former::radios('blank')->radios([
                'Yes' => ['value' => '1'],
                'No' => ['value' => '0']
            ])->inline()->label('Make link open in new window?') !!}
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Link Details <small>(Choose One..)</small></h3>
        </div>
        <div class="panel-body">
            <div class="col-md-6">{!! Former::text('url') !!}</div>
            <div class="col-md-6">{!! Former::text('route') !!}</div>
        </div>
    </div>

    <button class="btn-labeled btn btn-success pull-right" type="submit">
        <span class="btn-label"><i class="glyphicon glyphicon-ok"></i></span> Save
    </button>
</div>
{!! Former::close() !!}
