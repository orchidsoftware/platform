<div class="wrapper-md">

    <table class="table">
        <tr>
            <td>Название сайта</td>
            <td>{{$settings->get('name')}}</td>
        </tr>
        <tr>
            <td>Окружение</td>
            <td>{{$settings->get('env')}}</td>
        </tr>
        <tr>
            <td>Отладка</td>
            <td>{{$settings->get('debug')}}</td>
        </tr>
        <tr>
            <td>Адрес сайта</td>
            <td>{{$settings->get('url')}}</td>
        </tr>

        <tr>
            <td>Часовой пояс</td>
            <td>{{$settings->get('timezone')}}</td>
        </tr>


        <tr>
            <td>Язык по умолчанию</td>
            <td>{{$settings->get('locale')}}</td>
        </tr>

        <tr>
            <td>Запасной язык</td>
            <td>{{$settings->get('fallback_locale')}}</td>
        </tr>
        <tr>
            <td>Журнал событий</td>
            <td>{{$settings->get('log')}}</td>
        </tr>
        <tr>
            <td>Уровень журнала событий</td>
            <td>{{$settings->get('log_level')}}</td>
        </tr>


    </table>
</div>