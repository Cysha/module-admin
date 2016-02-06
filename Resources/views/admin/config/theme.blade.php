    <ul class="nav nav-tabs">
        <li class="active"><a href="#frontend" data-toggle="tab">Frontend Themes</a></li>
        <li><a href="#backend" data-toggle="tab">Backend Themes</a></li>
    </ul>

    <div class="tab-content">
    <?php
    $i = 0;
    foreach  (array('frontend', 'backend') as $set):
        $themes = Cms\Modules\Core\Models\Theme::{'get'.$set}();

        if ($set == 'frontend') {
            $setting = 'cms.core.app.themes.frontend';
            $settingValue = config($setting, 'default');
        } else {
            $setting = 'cms.core.app.themes.backend';
            $settingValue = config($setting, 'default_admin');
        }
    ?>
        <div class="tab-pane{{ ( $i++ == 0 ? ' active' : '') }}" id="{{ strtolower($set) }}">

            <div class="page-header">
                <h4>{{ ucwords($set) }} Themes</h4>
            </div>
            <table class="table">
                <tr>
                    <th width="20%">Theme Thumbnail</th>
                    <th width="30%">Theme Name</th>
                    <th width="20%">Author</th>
                    <th width="20%">Version</th>
                    <th width="5%">Default?</th>
                </tr>
                @foreach($themes as $theme)
                <tr>
                    <td></td>
                    <td>{{ ucwords($theme->name) }}</td>
                    <td>{{ $theme->author }}</td>
                    <td>{{ $theme->version }}</td>
                    <td>
                        @if($settingValue == $theme->dir)
                            <a href="#" class="btn btn-default btn-sm" disabled> Active </a>
                        @else

                        {!! Form::open(array('method' => 'post', 'url' => route('admin.config.store'))) !!}
                            {!! Form::hidden($setting, $theme->dir) !!}
                            {!! Form::submit('Activate?', array('class'=> 'btn btn-success btn-sm')) !!}
                        {!! Form::close() !!}

                        @endif
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    @endforeach
    </div>
