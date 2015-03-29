@include(partial('admin::widgets._counter'), [
    'counter'     => implode(', ', array_map(function ($value) {
        return number_format($value, 2);
    }, sys_getloadavg())),
    'title'       => 'Load Averages',
    'headerColor' => '#079DB7',
    'icon'        => 'fa fa-fw fa-graph-o'
])

<script>
jQuery(function () {
    setTimeout(function () {
        id = 'admin::widgets.loadAvg';
        ele = jQuery('[id="'+id+'"]');

        dashboard.load_data(id, ele.find('.grid-stack-item-content'));
    }, 5000);
});
</script>
