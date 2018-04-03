@extends('dashboard::layouts.dashboard')

@section('title','title')
@section('description', 'description')

@section('content')



<div class="admin-wrapper bg-white">

    <div class="wrapper-md">

        <div class="row">
            <div class="col-md-4">

                <div class="admin-element">
                    <h3 class="font-thin h3 text-black">
                        <i class="icon-energy"></i>Модерация
                    </h3>
                    <div class="line line-dashed b-b line-lg"></div>
                    <ul class="list-group no-bg no-borders pull-in auto m-l-lg">
                        <li class="list-group-item padder-v">
                            <a href="#" class="d-block padder">
                                <div>
                                    <span class="text-muted"><i class="icon-event pull-right m-t-sm text-lg"></i></span>
                                    <div class="clear">
                                        <div>Новости, ожидающие проверки</div>
                                        <small class="text-muted">Очень краткое описание, того, что делает этот пункт управления и что дозволенно пользователю</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item padder-v">
                            <a href="#" class="d-block padder">
                                <div>
                                    <span class="text-muted"><i class="icon-link pull-right m-t-sm text-lg"></i></span>
                                    <div class="clear">
                                        <div>Активные новости с битыми ссылками</div>
                                        <small class="text-muted">Очень краткое описание, того, что делает этот пункт управления и что дозволенно пользователю</small>
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li class="list-group-item padder-v">
                            <a href="#" class="d-block padder">
                                <div>
                                    <span class="text-muted"><i class="icon-book-open pull-right m-t-sm text-lg"></i></span>
                                    <div class="clear">
                                        <div>Активные новости с плохими текстами</div>
                                        <small class="text-muted">Очень краткое описание, того, что делает этот пункт управления и что дозволенно пользователю</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item padder-v">
                            <a href="#" class="d-block padder">
                                <div>
                                    <span class="text-muted"><i class="icon-bulb pull-right m-t-sm text-lg"></i></span>
                                    <div class="clear">
                                        <div>Фиолетовый список кампаний</div>
                                        <small class="text-muted">Очень краткое описание, того, что делает этот пункт управления и что дозволенно пользователю</small>
                                    </div>
                                </div>
                            </a>
                        </li>

                    </ul>
                </div>

                <div class="admin-element">
                    <h3 class="font-thin h3 text-black">
                        <i class="icon-feed"></i>RSS
                    </h3>
                    <div class="line line-dashed b-b line-lg"></div>
                    <ul class="list-group no-bg no-borders pull-in auto m-l-lg">
                        <li class="list-group-item padder-v">
                            <a href="#" class="d-block padder">
                                <div>
                                    <span class="text-muted"><i class="icon-list pull-right m-t-sm text-lg"></i></span>
                                    <div class="clear">
                                        <div>Список источников</div>
                                        <small class="text-muted">Очень краткое описание, того, что делает этот пункт управления и что дозволенно пользователю</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item padder-v">
                            <a href="#" class="d-block padder">
                                <div>
                                    <span class="text-muted"><i class="icon-layers pull-right m-t-sm text-lg"></i></span>
                                    <div class="clear">
                                        <div>Список статей</div>
                                        <small class="text-muted">Очень краткое описание, того, что делает этот пункт управления и что дозволенно пользователю</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item padder-v">
                            <a href="#" class="d-block padder">
                                <div>
                                    <span class="text-muted"><i class="icon-screen-smartphone pull-right m-t-sm text-lg"></i></span>
                                    <div class="clear">
                                        <div>Список пуш-уведомлений</div>
                                        <small class="text-muted">Очень краткое описание, того, что делает этот пункт управления и что дозволенно пользователю</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item padder-v">
                            <a href="#" class="d-block padder">
                                <div>
                                    <span class="text-muted"><i class="icon-share-alt pull-right m-t-sm text-lg"></i></span>
                                    <div class="clear">
                                        <div>Добавление новостей из агрегатора</div>
                                        <small class="text-muted">Очень краткое описание, того, что делает этот пункт управления и что дозволенно пользователю</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-4">

                <div class="admin-element">
                    <h3 class="font-thin h3 text-black">
                        <i class="icon-wrench"></i>Системные параметры
                    </h3>
                    <div class="line line-dashed b-b line-lg"></div>
                    <ul class="list-group no-bg no-borders pull-in auto m-l-lg">
                        <li class="list-group-item padder-v">
                            <a href="#" class="d-block padder">
                                <div>
                                    <span class="text-muted"><i class="icon-info pull-right m-t-sm text-lg"></i></span>
                                    <div class="clear">
                                        <div>Настроить системное уведомление</div>
                                        <small class="text-muted">Очень краткое описание, того, что делает этот пункт управления и что дозволенно пользователю</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item padder-v">
                            <a href="#" class="d-block padder">
                                <div>
                                    <span class="text-muted"><i class="icon-picture pull-right m-t-sm text-lg"></i></span>
                                    <div class="clear">
                                        <div>Добавление изображений на статику</div>
                                        <small class="text-muted">Очень краткое описание, того, что делает этот пункт управления и что дозволенно пользователю</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item padder-v">
                            <a href="#" class="d-block padder">
                                <div>
                                    <span class="text-muted"><i class="icon-task pull-right m-t-sm text-lg"></i></span>
                                    <div class="clear">
                                        <div>Инвалидатор кэша статики</div>
                                        <small class="text-muted">Очень краткое описание, того, что делает этот пункт управления и что дозволенно пользователю</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="admin-element">
                    <h3 class="font-thin h3 text-black">
                        <i class="icon-pie-chart"></i>Отчёты
                    </h3>
                    <div class="line line-dashed b-b line-lg"></div>
                    <ul class="list-group no-bg no-borders pull-in auto m-l-lg">
                        <li class="list-group-item padder-v">
                            <a href="#" class="d-block padder">
                                <div>
                                    <span class="text-muted"><i class="icon-fire pull-right m-t-sm text-lg"></i></span>
                                    <div class="clear">
                                        <div>Долг перед кампанией</div>
                                        <small class="text-muted">Очень краткое описание, того, что делает этот пункт управления и что дозволенно пользователю</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item padder-v">
                            <a href="#" class="d-block padder">
                                <div>
                                    <span class="text-muted"><i class="icon-eye pull-right m-t-sm text-lg"></i></span>
                                    <div class="clear">
                                        <div>Показы и клики кампании по странам</div>
                                        <small class="text-muted">Очень краткое описание, того, что делает этот пункт управления и что дозволенно пользователю</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item padder-v">
                            <a href="#" class="d-block padder">
                                <div>
                                    <span class="text-muted"><i class="icon-cursor pull-right m-t-sm text-lg"></i></span>
                                    <div class="clear">
                                        <div>Норм.СТП кампаний</div>
                                        <small class="text-muted">Очень краткое описание, того, что делает этот пункт управления и что дозволенно пользователю</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
    </div>

</div>


@stop