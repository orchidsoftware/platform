@extends('dashboard::layouts.install')

@section('title', trans('dashboard::install.welcome.title'))
@section('descriptions', trans('dashboard::install.welcome.message'))

@section('container')



    <h4 class="m-b font-thin b-b b-light-cs wrapper-xs">
        {{ trans('dashboard::install.welcome.message') }}
    </h4>

    <p>
        Идейные соображения высшего порядка, а также дальнейшее развитие различных форм деятельности требуют определения
        и уточнения систем массового участия. Задача организации, в особенности же новая модель организационной
        деятельности влечет за собой процесс внедрения и модернизации позиций, занимаемых участниками в отношении
        поставленных задач.
    </p>

    <p>
        Значимость этих проблем настолько очевидна, что новая модель организационной деятельности представляет собой
        интересный эксперимент проверки дальнейших направлений развития. Разнообразный и богатый опыт рамки и место
        обучения кадров представляет собой интересный эксперимент проверки форм развития.
    </p>



    <div class="row m-t-xl m-b-md wrapper-xs v-center block-xs">
        <div class="col-sm-6 col-xs-12 b-r b-light">
            <p class="text-xs">
                The MIT License (MIT) Copyright <br>© Chernyaev Alexandr
            </p>
        </div>
        <div class="col-sm-6 col-xs-12 text-right"><a href="{{ route('install::environment') }}"
                                                      class="btn btn-link text-ellipsis"> <span
                        class="text-md text-ellipsis">{{ trans('dashboard::install.next') }} <i
                            class="ion-ios-arrow-right m-l-xs"></i> </span></a>
        </div>
    </div>




@stop