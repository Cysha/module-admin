@extends(partial('admin::admin.config._form'))

@section('admin-form')
    <div class="alert alert-warning"><strong>Warning:</strong> This panel is still WIP and might not work 100%, if at all.</div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Cache</h3>
        </div>
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Cache</th>
                        <th>Last Cleared</th>
                        <th>Clear?</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>{!! Form::checkbox('cache[]') !!}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop
