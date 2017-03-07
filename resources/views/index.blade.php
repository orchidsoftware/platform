@extends('dashboard::layouts.dashboard')


@section('title','Панель управления')
@section('description','Добро пожаловать в Orchid')



@section('content')


    <div class="bg-white wrapper-lg box-shadow-lg">
        <ul class="nav nav-pills nav-xxs nav-rounded m-b-lg">
            <li class="active"><a href="">День</a></li>
            <li><a href="">Неделя</a></li>
            <li><a href="">Месяц</a></li>
        </ul>
        <div style="min-height: 360px; padding: 0; position: relative;">
            <canvas class="flot-base"
                    style="direction: ltr; position: absolute; left: 0; top: 0; height: 360px;"
                     height="360"></canvas>
            <div class="flot-text"
                 style="position: absolute; top: 0; left: 0; bottom: 0; right: 0; font-size: smaller; color: rgb(84, 84, 84);">
                <div class="flot-x-axis flot-x1-axis xAxis x1Axis"
                     style="position: absolute; top: 0; left: 0; bottom: 0; right: 0; display: block;">
                    <div style="position: absolute; max-width: 66px; top: 347px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 14px; text-align: center;">
                        0
                    </div>
                    <div style="position: absolute; max-width: 66px; top: 347px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 85px; text-align: center;">
                        1
                    </div>
                    <div style="position: absolute; max-width: 66px; top: 347px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 156px; text-align: center;">
                        2
                    </div>
                    <div style="position: absolute; max-width: 66px; top: 347px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 227px; text-align: center;">
                        3
                    </div>
                    <div style="position: absolute; max-width: 66px; top: 347px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 298px; text-align: center;">
                        4
                    </div>
                    <div style="position: absolute; max-width: 66px; top: 347px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 369px; text-align: center;">
                        5
                    </div>
                    <div style="position: absolute; max-width: 66px; top: 347px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 440px; text-align: center;">
                        6
                    </div>
                    <div style="position: absolute; max-width: 66px; top: 347px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 511px; text-align: center;">
                        7
                    </div>
                    <div style="position: absolute; max-width: 66px; top: 347px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 582px; text-align: center;">
                        8
                    </div>
                    <div style="position: absolute; max-width: 66px; top: 347px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 653px; text-align: center;">
                        9
                    </div>
                </div>
                <div class="flot-y-axis flot-y1-axis yAxis y1Axis"
                     style="position: absolute; top: 0; left: 0; bottom: 0; right: 0; display: block;">
                    <div style="position: absolute; top: 336px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 6px; text-align: right;">
                        4
                    </div>
                    <div style="position: absolute; top: 280px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 6px; text-align: right;">
                        6
                    </div>
                    <div style="position: absolute; top: 224px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 6px; text-align: right;">
                        8
                    </div>
                    <div style="position: absolute; top: 168px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 0; text-align: right;">
                        10
                    </div>
                    <div style="position: absolute; top: 112px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 0; text-align: right;">
                        12
                    </div>
                    <div style="position: absolute; top: 56px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 0; text-align: right;">
                        14
                    </div>
                    <div style="position: absolute; top: 1px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 0; text-align: right;">
                        16
                    </div>
                </div>
            </div>
            <canvas class="flot-overlay"
                    style="direction: ltr; position: absolute; left: 0; top: 0; height: 360px;"
                     height="360"></canvas>
        </div>
    </div>


@stop




