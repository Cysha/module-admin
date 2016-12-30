<div class="row">
{!! Former::horizontal_open() !!}
    <div class="col-md-9">
        <div class="alert alert-warning"><strong>Warning:</strong> This panel is still WIP and might not work 100%, if at all.</div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Navigation</h3>
            </div>
            <div class="panel-body">
                {!! Former::text('name') !!}
                {!! Former::text('class') !!}

                <button class="btn-labeled btn btn-success pull-right" type="submit">
                    <span class="btn-label"><i class="glyphicon glyphicon-ok"></i></span> Save
                </button>
            </div>
        </div>
    </div>
    {!! Former::close() !!}

    @if (isset($nav))
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="{{ route('admin.nav.links.create', $nav->name)}}" class="btn btn-info btn-xs pull-right">New Link</a>
                <h3 class="panel-title">Links</h3>
            </div>
            <table class="panel-body table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>URL / Route</th>
                        <th>Class</th>
                        <th>Blank</th>
                        <th>Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($nav->links->sortBy('order') as $link)
                    <tr>
                        <td>{{ $link->title }}</td>
                        <td><span title="{{ $link->url ?: route($link->route) }}" data-toggle="tooltip">{{ $link->url ?: $link->route }}</span></td>
                        <td>{{ $link->class }}</td>
                        @if ($link->blank)
                        <td><div class="label label-success">true</div></td>
                        @else
                        <td><div class="label label-warning">false</div></td>
                        @endif
                        <td>{{ $link->order }}</td>
                        <td>
                        <a href="{{ route('admin.nav.links.update', [
                            'admin_nav_name' => $nav->name,
                            'admin_link_id' => $link->id
                        ]) }}" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i></a>

                        @if ($link->order >= 1)
                        {!! Former::open(route('admin.nav.links.move-up', [
                            'admin_nav_name' => $nav->name,
                            'admin_link_id' => $link->id
                        ]))->style('display: inline-block;') !!}
                        <button type="submit" class="btn btn-xs btn-default" title="Move Up" data-toggle="tooltip"><i class="fa fa-arrow-up"></i></button>
                        {!! Former::close() !!}
                        @endif

                        {!! Former::open(route('admin.nav.links.move-down', [
                            'admin_nav_name' => $nav->name,
                            'admin_link_id' => $link->id
                        ]))->style('display: inline-block;') !!}
                        <button type="submit" class="btn btn-xs btn-default" title="Move Down" data-toggle="tooltip"><i class="fa fa-arrow-down"></i></button>
                        {!! Former::close() !!}


                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6"><div class="alert alert-info">No Links Found!</div></td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
