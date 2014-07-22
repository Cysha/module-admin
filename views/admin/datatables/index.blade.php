@if( ($alert = array_get($options, 'alert', false)) !== false )
    <div class="alert alert-{{ $alert['class'] }}">{{ $alert['text'] }}</div>
@endif

@if( array_get($options, 'pagination', false) || array_get($options, 'filtering', false) )
<div class="row">
    @if( array_get($options, 'filtering', false) )

    @if( array_get($options, 'pagination', false) )
    <div class="col-lg-6">
    @else
    <div class="col-lg-12">
    @endif
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Table Filter</h3>
            </div>
            <div class="panel-body">
                <form method="post" action="" accept-charset="utf-8" data-search data-grid="datagrid">
                <div class="row">
                    <div class="col-xs-4">
                        <select name="column" class="form-control">
                            @if( count($filterOptions) )
                                @foreach($filterOptions as $key => $row)
                                    <option value="{{ $key }}">{{ $row['th'] }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-xs-6">
                        <input class="form-control" name="filter" type="text" placeholder="Filter All">
                    </div>
                    <div class="col-xs-2">
                        <button class="btn btn-primary">Add Filter</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    @endif
    @if( array_get($options, 'pagination', false) )

    @if( array_get($options, 'filtering', false) )
    <div class="col-lg-6">
    @else
    <div class="col-lg-12">
    @endif
        <div class="panel panel-default pages">
            <div class="panel-heading">
                <h3 class="panel-title">Pagination</h3>
            </div>
            <div class="panel-body">
                <ul class="pagination" data-grid="datagrid">
                    <li data-template data-if-infinite data-page="[[ page ]]"><a href="#">Load More</a></li>
                    <li data-template data-if-throttle data-throttle><a href="#">More</a></li>
                    <li data-template data-page="[[ page ]]" class="[? if active ?]active[? endif ?]"><a href="#">[[ pageStart ]] - [[ pageLimit ]]</a></li>
                </ul>
            </div>
        </div>
    </div>
    @endif
</div>
@endif

@if( array_get($options, 'filtering', false) )
<div class="row">
    <div class="container">
        <ul class="applied applied-filters" data-grid="datagrid">
            <li data-template>
                [? if column == undefined ?]
                <a class="remove-filter well well-sm" href="#">
                    [[ valueLabel ]]
                    <span class="close"><span class="fa fa-times"></span></span>
                </a>
                [? else ?]
                <a class="remove-filter well well-sm" href="#">
                    [[ valueLabel ]] in [[ columnLabel ]]
                    <span class="close"><span class="fa fa-times"></span></span>
                </a>
                [? endif ?]
            </li>
        </ul>
    </div>
</div>
@endif

<?php $actions = Theme::getActions(); ?>
@if( isset($actions['table']) && count($actions['table']) )
    <?php $i = 0; ?>
    <ul class="nav nav-tabs quick-filter">
    @foreach($actions['table'] as $btn)
        <li{{ ($i == 0 ? ' class="active"' : '') }}>
            <?php
            $values = array();
            foreach( $btn as $key => $value ){
                if( substr($key, 0, 3) == 'btn' ){ continue; }

                if( empty($value) ){
                    $values[] = $key;
                }else{
                    $values[] = $key.'="'.$value.'"';
                }
            }
            ?>
            <a href="#" name="{{ Str::slug($btn['btn-text']) }}" data-grid="datagrid"{{ (count($values) ? ' '.implode(' ', $values) : '') }}>
                <span>{{ $btn['btn-text'] }}</span>
            </a>
        </li>
        <?php $i++; ?>
    @endforeach
    </ul>
@endif


<table class="table table-bordered table-hover table-sm results" data-grid="datagrid" data-source="{{ array_get($options, 'source', false) }}">
    <thead>
        <tr>
            @foreach($columns as $key => $col)
            <?php
                $extras = array(); $class = array();
                if( isset($col['width']) ){ $extras[] = 'width="'.$col['width'].'"'; }
                if( isset($col['th-class']) ){ $class[] = $col['th-class']; }
                if( isset($col['sorting']) && $col['sorting'] === true ){
                    $class[] = 'sortable';
                    $extras[] = 'data-sort="'.$key.'"';
                }
            ?>
            <th class="{{ implode(' ', $class) }}"{{ implode(' ', $extras) }} data-grid="datagrid">{{ $col['th'] }}</th>
            @endforeach
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <tr data-template>
            @foreach($columns as $col)
            <?php
                $extras = array(); $class = array();
                if( isset($col['tr-class']) ){ $class[] = $col['tr-class']; }
            ?>
            <td class="{{ implode(' ', $class) }}"{{ implode(' ', $extras) }}>{{ $col['tr'] }}</td>
            @endforeach

            <td class="text-center">
                <?php $actions = Theme::getActions(); ?>
                @if( isset($actions['row']) && count($actions['row']) )
                    @foreach($actions['row'] as $btn)
                    <a class="{{ $btn['btn-class'] }}" href="{{ $btn['btn-link'] }}">
                        <span class="btn-label"><i class="{{ $btn['btn-icon'] }}"></i></span><span>{{ $btn['btn-text'] }}</span>
                    </a>
                    @endforeach
                @endif
            </td>
        </tr>
        <tr data-results-fallback style="display:none;" class="danger">
            <td colspan="{{ (count($columns)+1) }}">No Results</td>
        </tr>
    </tbody>
</table>

@if( array_get($options, 'pagination', false) === false || array_get($options, 'filtering', false) === false )
<div class="hide">
    @if( array_get($options, 'filtering', false) === false )
        <div data-grid="datagrid" class="applied"></div>
    @endif
    @if( array_get($options, 'pagination', false) === false )
        <div data-grid="datagrid" class="pagination"></div>
    @endif
</div>
@endif

<script>
jQuery(function(){
    jQuery.datagrid('datagrid', '.results', '.pagination', '.applied', {
        "dividend": 10,
        "threshold": 100,
        "throttle": 500,
        "type": "multiple",
        "sort": {
            "column": "{{ array_get($options, 'sort_column', 'id') }}",
            "direction": "{{ array_get($options, 'sort_way', 'asc') }}"
        }
    });

    jQuery('ul.quick-filter li a').click(function(){
        jQuery('ul.quick-filter li').removeClass('active');

        jQuery(this).parent('li').addClass('active');
    });

    @if( array_get($options, 'filtering', false) && Request::get('filter') )
    var filter = "{{ Request::get('filter') }}";
    if( jQuery('a[data-filter][name*="'+filter+'"]').length ){
        jQuery('a[data-filter][name*="'+filter+'"]').click();
    }
    @endif
});
</script>