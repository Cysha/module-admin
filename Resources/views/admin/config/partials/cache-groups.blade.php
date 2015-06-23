<div class="row permission-groups">
@if (count($keys))
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-5"><h5><strong>{{ $title }}</strong></h5></div>
        </div>
        <div class="row">
            <hr>
        </div>
    @foreach ($keys as $key => $name)
        <div class="row permission-row">
            <div class="col-md-5"><h5>
                {{ $name }}
            </h5></div>
            <div class="col-md-7">
                {!! Form::checkbox('cache[]', $key) !!}
            </div>
        </div>
    @endforeach
    </div>
@else
    <div class="alert alert-info">Info: No cache keys could be found.</div>
@endif
</div>
