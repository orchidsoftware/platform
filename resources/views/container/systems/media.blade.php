@extends('platform::layouts.dashboard')

@section('controller','screen--base')
@section('title',$name)
@section('description',$description)

@section('navbar')
    <ul class="nav justify-content-end v-center">
        <li class="nav-item">
            <button type="button" class="btn btn-link dz-clickable" id="upload"><i class="icon-cloud-upload"></i>
                {{__('Upload')}}
            </button>
        </li>
        <li class="nav-item">
            <button type="button" class="btn btn-link" id="new_folder" data-action="components--media#new_folder"><i class="icon-folder-alt"></i>
                {{__('Create directory')}}
            </button>
        </li>
    </ul>
@endsection


@section('content')

    <style>

    </style>
    <div class=""
        data-controller="components--media"
        data-components--media-baseurl="{{ route('platform.systems.media.index') }}"
        data-components--media-path="{{$path}}">

        <div class="hbox hbox-auto-xs hbox-auto-sm pos-rlt">
            <div class="hbox-col">
                <div id="filemanager">
                    <div id="content">
                        <table class="table">
                            <thead>
                            <tr>
                                <th width="80px" class="text-center">
                                    <a href="?sort=content.ru.name" class=" text-muted ">
                                        Name
                                    </a>
                                </th>
                                <th class="text-center"></th>
                                <th class="text-center">

                                </th>
                                <th class="text-center">
                                    <a href="?sort=publish_at" class=" text-muted ">
                                        Size
                                    </a>
                                </th>
                                <th class="text-center">
                                    <a href="?sort=created_at" class=" text-muted ">
                                        Modified
                                    </a>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            {{-- Directories--}}
                            @foreach($directories as $directory)
                                <tr class="media-file"
                                    data-type="{{$directory['type']}}"
                                    data-src="{{$directory['path']}}"
                                    data-name="{{$directory['name']}}"
                                    data-size="{{$directory['size']}}"
                                    data-modified="{{$directory['lastModified']}}"
                                >
                                    <td class="text-center no-padder">
                                        <a href="{{route('platform.systems.media.index',$route.$directory['name'])}}">
                                            <i class="icon icon-folder-alt main-icon"></i> </a>

                                    </td>
                                    <td class="text-left media-name">
                                        <a href="{{route('platform.systems.media.index',$route.$directory['name'])}}">
                                            {{$directory['name']}}
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                           aria-haspopup="true" aria-expanded="false">
                                            <i class="icon-options"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item media-move">
                                                <i class="icon-cursor-move"></i>Переместить</a>
                                            <a class="dropdown-item media-rename">
                                                <i class="icon-font"></i>Переименовать</a>
                                            <a class="dropdown-item media-delete">
                                                <i class="icon-trash"></i> Удалить</a>
                                        </div>
                                    </td>
                                    <td class="text-center media-size media-view">
                                        -
                                    </td>
                                    <td class="text-center media-modified media-view">
                                        {{$directory['lastModified']}}
                                    </td>
                                </tr>
                            @endforeach
                            {{-- Directories--}}
                            {{-- Files--}}
                            @foreach($files as $file)
                                <tr class="media-file"
                                    data-type="{{$file['type']}}"
                                    data-src="{{$file['path']}}"
                                    data-name="{{$file['name']}}"
                                    data-size="{{$file['size']}}"
                                    data-modified="{{$file['lastModified']}}"
                                >
                                    <td class="text-center no-padder media-view">
                                            @if (str_is('image*',$file['type']))
                                                <img src="{{$file['path']}}" class="img-responsive b">
                                            @elseif(str_is('video*',$file['type']))
                                                <i class="main-icon icon icon-camrecorder"></i>
                                            @elseif (str_is('audio*',$file['type']))
                                                <i class="main-icon icon icon-music-tone"></i>
                                            @else
                                                <i class="main-icon icon icon-doc"></i>
                                            @endif
                                    </td>
                                    <td class="text-left media-name media-view">
                                            {{$file['name']}}
                                    </td>
                                    <td class="text-center">
                                        <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                           aria-haspopup="true" aria-expanded="false">
                                            <i class="icon-options"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item media-getlink">
                                                <i class="icon-link"></i> Скопировать ссылку</a>
                                            <a class="dropdown-item media-move">
                                                <i class="icon-cursor-move"></i>Переместить</a>
                                            <a class="dropdown-item media-rename">
                                                <i class="icon-font"></i>Переименовать</a>
                                            <a class="dropdown-item media-delete">
                                                <i class="icon-trash"></i> Удалить</a>
                                        </div>
                                    </td>
                                    <td class="text-right media-size media-view">
                                        {{$file['size']}}
                                    </td>
                                    <td class="text-center media-modified media-view">
                                        {{$file['lastModified']}}
                                    </td>
                                </tr>
                            @endforeach
                            {{-- Files--}}
                            </tbody>
                        </table>

                        <footer class="wrapper">
                            <div class="row">
                                <div class="col-sm-5">
                                    <small class="text-muted inline m-t-sm m-b-sm">{{$directories->count()}} folders
                                                                                                             and {{$files->count()}}
                                                                                                             files
                                    </small>
                                </div>
                                <div class="col-sm-7 text-right text-center-xs">

                                </div>
                            </div>
                        </footer>


                    </div>

                </div>
            </div>
            <div class="hbox-col b-l w-xxl">


                <div id="aside-filemanager" class="col wi-col no-padder">

                    <div class="right_none_selected" style="display: none;">
                        <i class="icon-cursor"></i>
                        <p> Ничего не выбрано</p>
                    </div>

                    <div class="wrapper detail v-center text-center" data-target="components--media.src">

                        <a href="" target="_blank" class="media-preview media-image" style="display: none;">
                            <img src="" class="img-responsive b">
                        </a>

                        <video width="100%" height="auto" controls class="media-preview media-video" style="display: none;">
                            <source src="selected_file.path" type="video/mp4">
                            <source src="selected_file.path" type="video/ogg">
                            <source src="selected_file.path" type="video/webm">

                            {{trans('platform::systems/media.video_support')}}
                        </video>


                        <div class="media-preview media-audio" style="display: none;">
                            <i class="icon-music-tone"></i>
                            <audio controls class="w-full">
                                <source src="selected_file.path" type="audio/ogg">
                                <source src="selected_file.path" type="audio/mpeg">
                                {{trans('platform::systems/media.audio_support')}}
                            </audio>
                        </div>


                        <i class="icon-folder-alt media-preview media-directory" style="display: none;"></i>

                        <a href="" target="_blank" class="media-preview media-doc" style="display: none;">
                            <i class="icon-doc" ></i>
                            <p>open</p>
                        </a>

                    </div>

                    <div class="divider b-t m-t-sm"></div>


                    <div class="wrapper">
                        <div class="row">
                            <div class="col-md-5">
                                Название :
                            </div>
                            <div class="col-md-7" data-target="components--media.name">
                                -
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                Тип файла:
                            </div>
                            <div class="col-md-7" data-target="components--media.type">
                                -
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                Размер:
                            </div>
                            <div class="col-md-7" data-target="components--media.size">
                                -
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                Модификация:
                            </div>
                            <div class="col-md-7" data-target="components--media.modified">
                                -
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <!-- Delete File Modal  -->
        <div class="modal fade modal-danger" id="confirm_delete_modal" >
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                        </button>
                        <h4 class="modal-title"><i class="icon-exclamation"></i>Удалить?</h4>
                    </div>

                    <div class="modal-body">
                        <h4 class="text-center">
                            Вы действительно хотите удалить '<span class="confirm_delete_name"></span>'
                        </h4>
                        <h5 class="folder_warning"><i class="icon-exclamation"></i>
                            Удаление папки приведет к удалению всего ее содержимого.</h5>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                        <button type="button" class="btn btn-danger" data-action="components--media#confirm_delete">Да, удалить!
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Delete File Modal  -->
        <!-- Rename File Modal  -->
        <div class="modal fade modal-warning" id="rename_file_modal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true">&times;
                        </button>
                        <h4 class="modal-title"><i class="icon-font"></i> {{trans('platform::systems/media.rename_file_folder')}}</h4>
                    </div>

                    <div class="modal-body">
                        <h4>{{trans('platform::systems/media.new_file_folder')}}</h4>
                        <input class="form-control new_filename" type="text">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('platform::systems/media.cancel')}}</button>
                        <button type="button" class="btn btn-warning" data-action="components--media#confirm_rename">{{trans('platform::systems/media.rename')}}</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Move File Modal  -->
        <!-- Move File Modal  -->
        <div class="modal fade modal-warning" id="move_file_modal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true">&times;
                        </button>
                        <h4 class="modal-title"><i class="icon-cursor-move"></i>{{trans('platform::systems/media.move_file_folder')}}</h4>
                        <span class="move_file_name"></span>
                    </div>

                    <div class="modal-body">
                        <h4>{{trans('platform::systems/media.destination_folder')}}</h4>
                        <input class="form-control move_folder" type="text">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('platform::systems/media.cancel')}}</button>
                        <button type="button" class="btn btn-warning" data-action="components--media#confirm_move">{{trans('platform::systems/media.move')}}</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Move File Modal  -->
        <!-- New Folder Modal  -->
        <div class="modal fade modal-info" id="new_folder_modal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true">&times;
                        </button>
                        <h4 class="modal-title  padder-v">
                            <i class="icon-folder-alt"></i>
                            {{trans('platform::systems/media.add_new_folder')}}
                        </h4>
                    </div>

                    <div class="modal-body">
                        <input name="new_folder_name" placeholder="New Folder Name"
                               class="form-control new_folder_name" value=""/>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('platform::systems/media.cancel')}}</button>
                        <button type="button" class="btn btn-info" data-action="components--media#confirm_new_folder">
                            {{trans('platform::systems/media.add_new_folder')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End New Folder Modal  -->
    </div>

@stop