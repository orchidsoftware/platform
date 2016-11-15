@extends('dashboard::layouts.dashboard')

@section('content')



    <div class="bg-light lter b-b wrapper-md">
        <h1 class="m-n font-thin h3">CRUD</h1>
        <small class="text-muted">Системные активные аккаунты</small>
    </div>

    <div class="wrapper-md" id="crud-container">


        <div class="panel-group" id="accordion-crud" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading-migrate">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion-crud" href="#collapse-migrate"
                           aria-expanded="true" aria-controls="collapse-migrate">
                            Миграции
                        </a>
                    </h4>
                </div>
                <div id="collapse-migrate" class="panel-collapse collapse in" role="tabpanel"
                     aria-labelledby="heading-migrate">
                    <div class="panel-body">


                        <form>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Имя таблицы</label>
                                <input type="text" class="form-control" placeholder="Имя таблицы" max="20" required>
                            </div>

                            <div class="entry input-group row">
                                <div class="form-group col-md-6">
                                    <label>Название поля</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <a class=" fa fa-plus btn-add"></a>
                                        </div>
                                        <input class="form-control" name="fields[][name]" type="text"
                                               placeholder="Название">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Тип поля</label>
                                    <input class="form-control" name="fields[][value]" type="text"
                                           placeholder="Значение">
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10 text-right">
                                    <button type="submit" class="btn btn-default">Создать</button>
                                </div>
                            </div>
                        </form>


                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading-model">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion-crud"
                           href="#collapse-model" aria-expanded="false" aria-controls="collapse-model">
                            Модель
                        </a>
                    </h4>
                </div>
                <div id="collapse-model" class="panel-collapse collapse" role="tabpanel"
                     aria-labelledby="heading-model">
                    <div class="panel-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                        3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt
                        laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin
                        coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes
                        anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings
                        occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard
                        of them accusamus labore sustainable VHS.
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading-controller">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion-crud"
                           href="#collapse-controller" aria-expanded="false" aria-controls="collapse-controller">
                            Контроллер
                        </a>
                    </h4>
                </div>
                <div id="collapse-controller" class="panel-collapse collapse" role="tabpanel"
                     aria-labelledby="heading-controller">
                    <div class="panel-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                        3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt
                        laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin
                        coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes
                        anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings
                        occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard
                        of them accusamus labore sustainable VHS.
                    </div>
                </div>
            </div>


            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading-views">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion-crud"
                           href="#collapse-views" aria-expanded="false" aria-controls="collapse-views">
                            Views
                        </a>
                    </h4>
                </div>
                <div id="collapse-views" class="panel-collapse collapse" role="tabpanel"
                     aria-labelledby="heading-views">
                    <div class="panel-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                        3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt
                        laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin
                        coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes
                        anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings
                        occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard
                        of them accusamus labore sustainable VHS.
                    </div>
                </div>
            </div>


        </div>


    </div>







@endsection
