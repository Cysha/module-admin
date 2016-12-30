@extends(partial('admin::admin.config._layout'))

@section('admin-config')
    <div class="alert alert-warning"><strong>Warning:</strong> This panel is still WIP and might not work 100%, if at all.</div>

    @include(partial('admin::admin.datatable.index'), compact('tableConfig', 'options', 'columns', 'data'))

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">Dashboard Preview</div>
        </div>
        <div class="panel-body" style="position: relative;height: 80vh;">
            @include('admin::admin.dashboard.index', compact('gridLayout'))
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addWidget" tabindex="-1" role="dialog" aria-labelledby="addWidgetLabel">
        {!! Former::horizontal_open(route('admin.widget.create')) !!}
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addWidgetLabel">Add new widget instance</h4>
                </div>
                <div class="modal-body">
                    {!! Former::select('component')->options($widgets) !!}
                    {!! Former::text('grid')->inlineHelp('You can define single grid coordinates or give it a range for this widget to expand over, eg a1 will make the widget 1 square big on the grid, but a1:b2 will expand it into a 2x2 space.') !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close Modal</button>
                    <button type="submit" class="btn btn-primary">Add Widget</button>
                </div>
            </div>
        </div>
        {!! Former::close() !!}
    </div>
@stop
