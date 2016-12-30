<div class="dashboard">
@forelse($gridLayout as $widget)
    @set($component, array_get($widget, 'component'))
    @set($options, array_get($widget, 'options'))
    @set($options['grid'], array_get($widget, 'grid'))

    <{{ $component }}{!! $builder->attributes($options) !!}></{{ $component }}>
@empty
@endforelse
</div>

<script>
window.Laravel = {
    csrfToken: '{{ csrf_token() }}',
    apiKey: 'dashboard_4y2424h2784h923492h'
};

window.Vue = new Vue({
    el: '.dashboard'
});
</script>
