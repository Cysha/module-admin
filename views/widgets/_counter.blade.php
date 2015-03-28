<div class="panel status panel-default">
    <div class="panel-heading" style="background-color: {{ $headerColor }};">
        <h1 class="panel-title text-center">{{ $counter or 0 }}</h1>
    </div>
    <div class="panel-body text-center">
        <strong><i class="{{ $icon or '' }}"></i> {{{ $title or '' }}}</strong>
    </div>
</div>
