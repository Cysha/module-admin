@include(partial('admin::widgets._counter'), [
    'counter'     => $memory,
    'title'       => 'Memory Usage',
    'headerColor' => '#079DB7',
    'icon'        => 'fa fa-fw fa-graph-o'
])

<script>
jQuery(function () {
    setTimeout(function () {
        id = 'admin::widgets.memoryUsage';
        ele = jQuery('[id="'+id+'"]');

        dashboard.load_data(id, ele.find('.grid-stack-item-content'));
    }, 5000);
});
</script>
