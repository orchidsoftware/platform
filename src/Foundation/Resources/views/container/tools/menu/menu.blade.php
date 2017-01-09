@extends('dashboard::layouts.dashboard')


@section('title','Меню')
@section('description','Верхнее')


@section('navbar')
    <div class="col-sm-6 col-xs-12 text-right">
        <div class="btn-group" role="group">
            <a href="{{ route('dashboard.tools.section.create')}}" class="btn btn-link"><i
                        class="ion-ios-plus-outline fa fa-2x"></i></a>
        </div>
    </div>
@stop



@section('content')


    <style>

        .dd {
            max-width: 100%;
        }

        .edit {
            position: absolute;
            margin: 0;
            right: 0;
            top: 0;
            cursor: pointer;
            width: 40px;
            text-indent: 100%;
            white-space: nowrap;
            overflow: hidden;
            border: 1px solid #ebebeb;
            background: #fff;
            border-top-right-radius: 0;
            padding: 10px 10px;
        }
    </style>



    <div id="menu-vue" class="wrapper-md">


        <div class="row">
            <div class="col-sm-4">

            </div>
            <div class="col-sm-8">
                <div class="dd">
                    <ol class="dd-list">
                        <li class="dd-item dd3-item" data-id="13" data-sort="1">
                            <div class="dd-handle dd3-handle">Drag</div>
                            <div class="dd3-content">Элемент 13</div>
                            <div class="edit"><i class="fa fa-user"></i></div>
                        </li>
                        <li class="dd-item dd3-item" data-id="14" data-sort="1">
                            <div class="dd-handle dd3-handle">Drag</div>
                            <div class="dd3-content">Элемент 14</div>
                        </li>
                        <li class="dd-item dd3-item" data-id="15" data-sort="1">
                            <div class="dd-handle dd3-handle">Drag</div>
                            <div class="dd3-content">Элемент 15</div>
                            <ol class="dd-list">
                                <li class="dd-item dd3-item" data-id="16" data-sort="1">
                                    <div class="dd-handle dd3-handle">Drag</div>
                                    <div class="dd3-content">Элемент 16</div>
                                </li>
                                <li class="dd-item dd3-item" data-id="17" data-sort="1">
                                    <div class="dd-handle dd3-handle">Drag</div>
                                    <div class="dd3-content">Элемент 17</div>
                                </li>
                                <li class="dd-item dd3-item" data-id="18" data-sort="1">
                                    <div class="dd-handle dd3-handle">Drag</div>
                                    <div class="dd3-content">Элемент 18</div>
                                </li>
                            </ol>
                        </li>
                    </ol>
                </div>
            </div>

        </div>


        <pre class="code">

        </pre>


        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <form class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel" v-html="label"></h4>
                    </div>
                    <div class="modal-body">


                        <div class="form-group">
                            <label for="exampleInputEmail1">Название</label>
                            <input type="text" class="form-control" v-model="label" placeholder="О нас">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Slug</label>
                            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="/about">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Разрешить поисковым роботам переход</label>
                            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="/about">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Класс</label>
                            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="/about">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Link Target</label>
                            <input type="text" class="form-control" id="exampleInputP   assword1" placeholder="/about">
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Удалить элемент</button>
                        <button type="button" v-on:click="save()" class="btn btn-primary">Сохранить изменения</button>
                    </div>
                </div>
            </form>
        </div>


    </div>








    <script>
        window.onload = function () {

            menu = new Vue({
                el: '#menu-vue',
                data: {
                    label: 'Hello Vue!',
                    slug: '',
                    robot: '',
                    class: '',
                    target: '',
                    element: '',
                },
                methods: {
                    load: function (object) {
                        this.label = object.label;
                        this.slug = object.slug;
                        this.robot = object.robot;
                        this.class = object.class;
                        this.target = object.target;
                        this.element = object.element;
                    },
                    save: function () {
                        $(this.element).data('label', this.label);
                        console.log('Сохранить');
                    }
                }

            });


            $('.dd').nestable({/* config options */});

            $('.dd').on('change', function () {
                alert('Изменение');


                $('.code').html(JSON.stringify($('.dd').nestable('serialize')));
            });
            $('.code').html(JSON.stringify($('.dd').nestable('serialize')));


            //Сортировка
            $('.dd-item').each(function (i, item) {
                $(item).data('sort', i);
            });


            $('.edit').click(function (e) {

                var data = $(this).parent().data();
                data.label = $(this).prev().text();
                data.element = $(this).parent();

                //console.log(data);
                $('#myModal').modal({
                    show: true,
                });


                menu.load(data);// = data;
            });

        };
    </script>

@stop