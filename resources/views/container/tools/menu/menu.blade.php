@extends('dashboard::layouts.dashboard')


@section('title','Меню')
@section('description',$nameMenu)


@section('navbar')
    <div class="col-sm-6 col-xs-12 text-right">


        <ul class="nav navbar-nav navbar-right">
            @if(count($locales) > 1)
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                   aria-expanded="false">{{$locales[$currentLocale]['native']}} <span class="caret"></span></a>
                <ul class="dropdown-menu">

                    @foreach($locales as $code => $locale)
                        @if($currentLocale == $code)
                        <li class="disabled">
                            <a>{{$locale['native']}}</a>
                        </li>
                        @else
                            <li>
                                <a href="?lang={{$code}}">{{$locale['native']}}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
            @endif

            <li>
                <button class="btn btn-link menu-save"><i
                            class="icon-plus fa fa-2x"></i></button>
            </li>

        </ul>

    </div>
@stop



@section('content')


    <div class="hbox hbox-auto-xs hbox-auto-sm" id="menu-vue">




        <div class="col w-xxl bg-white-only b-r bg-auto no-border-xs">
            <div class="nav-tabs-alt hidden">
                <ul class="nav nav-tabs nav-justified" role="tablist">
                    <li>
                        <a data-target="#static-pages" role="tab" data-toggle="tab" aria-expanded="false">
                            <i class="icon-note text-md text-muted wrapper-sm"></i>
                            Pages
                        </a>
                    </li>
                    <li class="active">
                        <a id="ahref-custom-pages" data-target="#custom-pages" role="tab" data-toggle="tab" aria-expanded="true">
                            <i class="icon-wrench text-md text-muted wrapper-sm"></i>
                            Custom
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane" id="static-pages">

                    <div class="wrapper-md">
                        <label class="small">Поиск</label>
                        <input class="form-control form-control-grey input-sm" placeholder="Not Work">
                    </div>


                    <div class="list-group">
                        @foreach($staticPage as $slug => $name)
                            <button v-on:click="addStatic('{{$name}}','{{$slug}}')"  type="button" class="list-group-item text-ellipsis" title="{{$name}}">
                                <span class="block">{{$name}}</span>
                                <small>{{$url}}/<span>{{$slug}}</span></small>
                            </button>
                        @endforeach
                    </div>

                </div>

                <div role="tabpanel" class="tab-pane tab-3 active" id="custom-pages">
                    <div class="wrapper-md">


                    <div class="form">
                        <div class="form-group">
                            <label>Название</label>
                            <input type="text" class="form-control" v-model="label" placeholder="О нас">
                        </div>
                        <div class="form-group">
                            <label>Подпись</label>
                            <input type="text" class="form-control" v-model="title" placeholder="История нашей компании">
                        </div>
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" class="form-control" v-model="slug" placeholder="/about">
                        </div>

                        <div class="form-group">
                            <label>Отображение</label>
                            <select class="form-control" v-model="auth">
                                <option value="0" selected>Доступно всем</option>
                                <option value="1">Только авторизованным пользователям</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Отношения между текущим документом и документом, на который ведет ссылка</label>

                            <select class="form-control" v-model="robot">

                                <option value="answer">Ответ на вопрос</option>
                                <option value="chapter">Раздел или глава текущего документа</option>
                                <option value="co-worker">Ссылка на страницу коллеги по работе</option>
                                <option value="colleague">Ссылка на страницу коллеги (не по работе)</option>
                                <option value="contact">Ссылка на страницу с контактной информацией</option>
                                <option value="details">Ссылка на страницу с подробностями</option>
                                <option value="edit">Редактируемая версия текущего документа</option>
                                <option value="friend">Ссылка на страницу друга</option>
                                <option value="question">Вопрос</option>

                                <option value="archives">Ссылка на архив сайта</option>
                                <option value="author">Ссылка на страницу об авторе на том же домене</option>
                                <option value="bookmark">Постоянная ссылка на раздел или запись</option>
                                <option value="first">Ссылка на первую страницу</option>
                                <option value="help">Ссылка на документ со справкой</option>
                                <option value="index">Ссылка на содержание</option>
                                <option value="last">Ссылка на последнюю страницу</option>
                                <option value="license">Ссылка на страницу с лицензионным соглашением или авторскими правами</option>
                                <option value="me">Ссылка на страницу автора на другом домене</option>
                                <option value="next">Ссылка на следующую страницу или раздел.</option>
                                <option value="nofollow">Не передавать по ссылке ТИЦ и PR.</option>
                                <option value="noreferrer">Не передавать по ссылке HTTP-заголовки</option>
                                <option value="prefetch">Указывает, что надо заранее кэшировать указанный ресурс</option>
                                <option value="prev">Ссылка на предыдущую страницу или раздел</option>
                                <option value="search">Ссылка на поиск</option>
                                <option value="sidebar">Добавить ссылку в избранное браузера</option>
                                <option value="tag">Указывает, что метка (тег) имеет отношение к текущему документу</option>
                                <option value="up">Ссылка на родительскую страницу</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label>Класс</label>
                            <input type="text" class="form-control" v-model="style" placeholder="/about">
                        </div>
                        <div class="form-group">
                            <label>Link Target</label>
                            <select class="form-control" v-model="target">
                                <option value="_self" selected>Отобразить в текущее окно</option>
                                <option value="_blank">Отобразить в новом окне</option>
                            </select>

                        </div>


                    </div>


                        <div class="text-center">


                            <div class="btn-group btn-group-sm  btn-group-justified" role="group" aria-label="...">


                                <div class="btn-group" role="group" v-if="exist()">
                                <button type="button" v-on:click="remove()" class="btn btn-sm btn-danger padder-md m-b text-ellipsis" data-dismiss="modal">Удалить

                                </button>
                                </div>

                                <div class="btn-group" role="group"  v-if="exist()">
                                    <button type="button" v-on:click="clear()" class="btn btn-sm btn-default padder-md m-b text-ellipsis" data-dismiss="modal">Сбросить
                                </button>

                                </div>

                                <div class="btn-group" role="group"  v-if="!exist()">
                                    <button  type="button" v-on:click="add()" class="btn btn-sm btn-primary padder-md m-b text-ellipsis">Добавить</button>
                                </div>

                                <div class="btn-group" role="group"  v-if="exist()">
                                    <button  type="button" v-on:click="save()" class="btn btn-sm btn-primary padder-md m-b text-ellipsis">Сохранить</button>
                                </div>

                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>




    <div class="col">
    <div class="wrapper-md">


        <div class="row">
            <div class="col-sm-12">
                <div class="dd" data-lang="{{$currentLocale}}" data-name="{{$nameMenu}}">
                    <ol class="dd-list">
                        @include('dashboard::partials.menu.item',[
                            'menu'=>$menu
                        ])
                    </ol>
                </div>
            </div>

        </div>



    </div>
    </div>






</div>




    <script>
        window.onload = function () {

            const menu = new Vue({
                el: '#menu-vue',
                data: {
                    count: 0,
                    id: '',
                    label: '',
                    title: '',
                    slug: '',
                    auth: 0,
                    robot: 'follow',
                    style: '',
                    target: '_self'
                },
                methods: {
                    load: function (object) {
                        this.id = object.id;
                        this.label = object.label;
                        this.slug = object.slug;
                        this.auth = object.auth;
                        this.robot = object.robot;
                        this.style = object.style;
                        this.target = object.target;
                        this.title = object.title;
                    },
                    add: function () {
                        $(".dd > .dd-list").append("<li class='dd-item dd3-item' data-id='" + this.count + "'> " +
                            "<div class='dd-handle dd3-handle'>Drag</div><div class='dd3-content'>" + this.label + "</div> " +
                            "<div class='edit'></div>" +
                            "</li>");


                        $('li[data-id=' + this.count + ']').data({
                            'label': this.label,
                            'title': this.title,
                            'auth': this.auth,
                            'slug': this.slug,
                            'robot': this.robot,
                            'style': this.style,
                            'target': this.target
                        });

                        this.count--;
                        this.clear();
                    },
                    addStatic: function (name,slug) {

                        if(slug.charAt(0) != '/'){
                            slug = '/' + slug;
                        }

                        this.label = name;
                        this.slug = slug;

                        $('#ahref-custom-pages').tab('show');

                    },
                    edit: function (element) {
                        var data = $(element).parent().data();
                        data.label = $(element).prev().text();


                        this.load(data);
                    },
                    save: function () {


                        $('li[data-id=' + this.id + ']').data({
                            'label': this.label,
                            'title': this.title,
                            'auth': this.auth,
                            'slug': this.slug,
                            'robot': this.robot,
                            'style': this.style,
                            'target': this.target
                        });
                        $('li[data-id=' + this.id + '] > .dd3-content').html(this.label);


                        this.clear();
                        $('#menuEdit').modal('hide');

                    },
                    remove: function () {
                        $('li[data-id=' + this.id + ']').remove();
                        $('#menuEdit').modal('hide');
                        this.clear();
                    },
                    clear: function () {
                        this.label = '';
                        this.title = '';
                        this.auth = 0;
                        this.slug = '';
                        this.robot = 'follow';
                        this.style = '';
                        this.target = '_self';
                        this.id = '';
                    },
                    send: function () {
                        //Отправка данных

                        var name = $('.dd').attr('data-name');

                        var data = {
                            'lang': $('.dd').attr('data-lang'),
                            'data': $('.dd').nestable('serialize')
                        };

                        this.$http.put('/dashboard/tools/menu/' + name,data).then(function (response) {

                            alert('Сохраненно');
                            /*
                            swal({
                                title: response.data.title,
                                text: response.data.message,
                                timer: 2000,
                                showConfirmButton: false,
                                type: response.data.type,
                            });
                            */

                        });
                    },
                    exist: function(){

                        return !!(Number.isInteger(this.id) && $('li[data-id=' + this.id + ']').length > 0);

                    }

                }

            });


            $('.dd').nestable({});
            $('.dd-item').each(function (i, item) {
                $(item).data('sort', i);
            });

            $('.dd').on('click', '.edit', function () {
                menu.edit(this);
            });


            $('.menu-save').click(function () {
                menu.send();
            });


        };
    </script>

@stop