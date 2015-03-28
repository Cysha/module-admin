<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <div class="pull-left">CMS Updates</div>
        <div class="pull-right"><small>
            @if (array_get($info, 'upToDate', false) === false)
                New version availiable.
            @else
                This is the latest version.
            @endif
        </small></div>
    </div>
    <ul class="list-group">
        <div class="list-group-item">
            <p>You are currently running <a href="https://github.com/Cysha/PhoenixCMS/commit/{{ array_get($info, 'currentVersion') }}" target="_blank">{{{ substr(array_get($info, 'currentVersion'), 0, 10) }}}</a>.</p>
        </div>

        @foreach (array_get($info, 'commits') as $commit)
        <div class="list-group-item">
            <div class="row">
                <div class="col-md-2 text-center">
                    <img src="{{ array_get($commit, 'author.avatar_url') }}" class="img-circle" style="width: 45px;">
                </div>
                <div class="col-md-10">
                    <div class="row">
                        <a href="{{ array_get($commit, 'html_url') }}" title="{{{ array_get($commit, 'commit.message') }}}" target="_blank"><span style="font-size: 20px; font-weight: bold; margin-bottom: 5px;">{{{ Str::limit(array_get($commit, 'commit.message'), 50) }}}</span></a>
                    </div>
                    <div class="row">
                        <span>Posted {{ array_get($commit, 'commit.author.date') }} by <a href="{{ array_get($commit, 'author.html_url') }}" target="_blank">{{ array_get($commit, 'author.login') }}</a></span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </ul>
</div>
