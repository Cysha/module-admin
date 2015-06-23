@extends(partial('admin::admin.config._layout'))

@section('admin-config')
{!! Former::horizontal_open() !!}
    <div class="alert alert-info">
        <p><strong>Warning:</strong> You can use the checkboxes on the side of this table to clear specific cache keys.</p>
    </div>
    <div class="panel panel-default panel-permissions">
        <div class="panel-heading">
            <h3 class="panel-title">Cache</h3>
        </div>
        <div class="panel-body no-padding row">
            <?php
                $tier_one = [];
                $tier_two = [];
                foreach ($keys as $key => $name) {
                    list($a, $b) = explode('_', $key);
                    $tier_one[] = $a;
                    $tier_two[$a][$key] = $name;
                }
                $tier_one = array_unique($tier_one);

            ?>

            <div class="col-md-2 permissions-nav module">
                <ul class="nav nav-pills nav-stacked" id="permissions">
                    <li class="disabled">Module</li>
                @set($active_t1, false)
                @foreach($tier_one as $module)
                    @if($active_t1 === false)
                        @set($active_t1, true)
                        <li class="active">
                    @else
                        <li>
                    @endif

                        <a href="#t1_{{ $module }}" data-toggle="pill">{{ ucwords($module) }}</a>
                    </li>
                @endforeach
                </ul>
            </div>

            <div class="col-md-10">
                <div class="tab-content">
                @set($active_t1, false)
                @foreach($tier_one as $group)
                    @if($active_t1 === false)
                        @set($active_t1, true)
                        <div class="tab-pane active" id="t1_{{ $group }}">
                    @else
                        <div class="tab-pane" id="t1_{{ $group }}">
                    @endif

                    @include(partial('admin::admin.config.partials.cache-groups'), [
                        'title' => ucwords($group.' Cache Keys'),
                        'keys' => $tier_two[$group],
                    ])

                    </div>
                @endforeach
                </div>
            </div>

        </div>
        <div class="panel-footer clearfix">
            <button class="btn-labeled btn btn-success pull-right" type="submit">
                <span class="btn-label"><i class="glyphicon glyphicon-ok"></i></span> Clear Caches
            </button>
        </div>
    </div>
{!! Former::close() !!}

<script>
    (function ($) {
        $('select.master-select').on('change', function () {
            var value = $(this).find(':selected').attr('class');

            $(this)
                .parents('.permission-groups')      /* goto parent */
                .find('.permission-row select')     /* find the children select boxes */
                .val(value)                         /* change the values */
                .change();                          /* trigger a change to make it update */
        });
    })(jQuery);
</script>
@stop
