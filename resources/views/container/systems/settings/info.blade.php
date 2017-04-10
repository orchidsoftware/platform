<div class="wrapper-md">

    <table class="table">
        <tr>
            <td>{{trans('dashboard::systems/settings.Name of the site')}}</td>
            <td>{{$settings->get('name')}}</td>
        </tr>
        <tr>
            <td>{{trans('dashboard::systems/settings.Environment')}}</td>
            <td>{{$settings->get('env')}}</td>
        </tr>
        <tr>
            <td>{{trans('dashboard::systems/settings.Debugging')}}</td>
            <td>{{  $settings->get('debug') ? 'true' : 'false' }}</td>
        </tr>
        <tr>
            <td>{{trans('dashboard::systems/settings.Website address')}}</td>
            <td>{{$settings->get('url')}}</td>
        </tr>

        <tr>
            <td>{{trans('dashboard::systems/settings.Timezone')}}</td>
            <td>{{$settings->get('timezone')}}</td>
        </tr>


        <tr>
            <td>{{trans('dashboard::systems/settings.Default Language')}}</td>
            <td>{{$settings->get('locale')}}</td>
        </tr>

        <tr>
            <td>{{trans('dashboard::systems/settings.Replacement language')}}</td>
            <td>{{$settings->get('fallback_locale')}}</td>
        </tr>
        <tr>
            <td>{{trans('dashboard::systems/settings.The event log')}}</td>
            <td>{{$settings->get('log')}}</td>
        </tr>
        <tr>
            <td>{{trans('dashboard::systems/settings.Level Event Log')}}</td>
            <td>{{$settings->get('log_level')}}</td>
        </tr>


    </table>
</div>
