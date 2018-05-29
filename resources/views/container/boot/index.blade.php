@extends('platform::layouts.dashboard')

@section('title','Boot')
@section('description','Boot Details')

@section('navbar')

    <ul class="nav justify-content-end  v-center">
        <li class="nav-item">
            <button type="button" class="btn btn-link"><i class="icon-plus-alt"></i>
               Добавить новую модель
            </button>
        </li>
        <li class="nav-item">
            <button type="button" class="btn btn-link"><i class="icon-check"></i>
               Сохранить
            </button>
        </li>
        <li class="nav-item">
            <button type="button" class="btn btn-link"><i class="icon-trash"></i>
                Удалить
            </button>
        </li>
    </ul>

@stop

@section('content')


    <div class="hbox hbox-auto-xs hbox-auto-sm">

        <div class="hbox-col w-xxl bg-white-only b-r bg-auto no-border-xs">

            <div class="wrapper-md">

                <div class="form">

                    <div class="form-group">
                        <h5 class="text-black font-thin">Fillable / Guarded :</h5>
                        <small>Choose your preferred security style</small>

                        <select name="model" class="form-control m-t-md">
                            <option value="1">Fillable</option>
                            <option value="0">Guarded</option>
                        </select>
                    </div>

                    <div class="form-group m-t-md">
                        <h5 class="text-black font-thin">Special Columns :</h5>
                        <small>Choose unique column functions</small>

                        <div class="padder m-t-md">
                            <div class="checkbox m-t-sm">
                                <label class="i-checks">
                                    <input type="checkbox" value="230" name="content[en][free]" title="Free" placeholder="Event for free" lang="en" checked="">
                                    <i></i> Use Timestamps
                                </label>
                            </div>
                            <div class="checkbox m-t-sm">
                                <label class="i-checks">
                                    <input type="checkbox" value="230" name="content[en][free]" title="Free" placeholder="Event for free" lang="en" checked="">
                                    <i></i> Use Timestamps with Timezone
                                </label>
                            </div>
                            <div class="checkbox m-t-sm">
                                <label class="i-checks">
                                    <input type="checkbox" value="230" name="content[en][free]" title="Free" placeholder="Event for free" lang="en" checked="">
                                    <i></i> Use Soft Deletes
                                </label>
                            </div>
                            <div class="checkbox m-t-sm">
                                <label class="i-checks">
                                    <input type="checkbox" value="230" name="content[en][free]" title="Free" placeholder="Event for free" lang="en" checked="">
                                    <i></i> Use Remember Token
                                </label>
                            </div>
                        </div>
                        <small class="form-text text-danger none" id="errors.label">{{trans('platform::common.validation.required')}}</small>
                    </div>

                </div>

            </div>

        </div>


        <div class="hbox-col">
            <div class="wrapper-md">

                <div class="row">
                    <div class="col-sm-12">


                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection