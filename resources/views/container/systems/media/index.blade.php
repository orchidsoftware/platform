@extends('dashboard::layouts.dashboard')

@section('title',$name)
@section('description',$description)

@section('navbar')

    <ul class="nav justify-content-end  v-center">
        <li></li>
    </ul>

    <div class="nav justify-content-end v-center">

        <div class="btn-group">
                <button type="button" class="btn btn-link" id="upload"><i class="icon-cloud-upload"></i>
                    {{trans('dashboard::systems/media.upload')}}
                </button>
                <button type="button" class="btn btn-link" id="new_folder"
                        onclick="jQuery('#new_folder_modal').modal('show');"><i class="icon-folder-alt"></i>
                    {{trans('dashboard::systems/media.create_new_folder')}}
                </button>

                <button type="button" class="btn btn-link" id="refresh"><i class="icon-refresh"></i>
				    {{trans('dashboard::systems/media.refresh')}}
                </button>
                 <button type="button" class="btn btn-link" id="move"><i class="icon-cursor-move"></i>
                     {{trans('dashboard::systems/media.move_file_folder')}}
                </button>
                <button type="button" class="btn btn-link" id="rename"><i class="fa fa fa-font"></i>
                    {{trans('dashboard::systems/media.new_file_folder')}}
                </button>
                <button type="button" class="btn btn-link" id="delete"><i class="icon-trash"></i>
                    {{trans('dashboard::systems/media.delete')}}
                </button>
        </div>

    </div>


@stop

@section('content')


    <div class="page-content">

        <div id="filemanager" data-url="{{ route('dashboard.index')}}/systems">


            <div id="uploadPreview" style="display:none;"></div>

            <div id="uploadProgress" class="progress active progress-striped">
                <div class="progress-bar progress-bar-success" style="width: 0"></div>
            </div>


            <div id="content">

                <div class="breadcrumb-container">
                    <ol class="breadcrumb filemanager b-t small">
                        <li data-folder="/" data-index="0"><span class="arrow"></span>
                            <span> {{trans('dashboard::systems/media.library')}}</span>
                        </li>

                        <li v-for="(folder,index) in folders" v-bind:data-folder="folder"
                            v-bind:data-index="index+1">
                            <span class="arrow"></span>@{{ folder }}
                        </li>
                    </ol>

                </div>
                <div class="flex">

                    <div id="left" class="col">

                        <ul id="files">

                            <li v-for="(file,index) in files.items">
                                <div class="file_link" v-bind:data-folder="file.name" v-bind:data-index="index"
                                     v-bind:title="file.name">
                                    <div class="link_icon">

                                        <div v-if="file.type.includes('image')" class="img_icon"
                                             style="background: no-repeat center center;display:inline-block; width:100%; height:100%;background-size: cover;"
                                             v-bind:style="{ backgroundImage: 'url(' + encodeURI(file.path) + ')' }"
                                        >
                                        </div>

                                        <i v-if="file.type.includes('video')"
                                           class="icon icon-camrecorder"></i>

                                        <i v-if="file.type.includes('audio')" class="icon icon-music-tone"></i>

                                        <i v-if="file.type == 'folder'" class="icon icon-folder-alt"></i>

                                        <i v-if="file.type != 'folder' && !file.type.includes('image') && !file.type.includes('video') && !file.type.includes('audio')"
                                           class="icon icon-doc"></i>

                                    </div>
                                    <div class="details" v-bind:class="file.type"><h4>@{{ file.name }}</h4>
                                        <small>
                                            <span v-if="file.type != 'folder'"
                                                  class="file_size">@{{ file.size }}</span>
                                        </small>
                                    </div>
                                </div>
                            </li>

                        </ul>

                        <div id="file_loader">
                            <p>{{trans('dashboard::systems/media.loading')}}</p>
                        </div>

                        <div id="no_files">
                            <h3 class="font-thin"><i class="icon-directions"></i> {{trans('dashboard::systems/media.no_files_here')}}</h3>
                        </div>

                    </div>

                    <div id="right" class="col w-xxl no-padder">
                        <div class="right_none_selected">
                            <i class="icon-cursor"></i>
                            <p> {{trans('dashboard::systems/media.nothing_selected')}}</p>
                        </div>
                        <div class="right_details">
                            <div class="detail_img"
                                 v-if="selected_file != undefined && selected_file.type != undefined">


                                <a v-bind:href="selected_file.path" target="_blank"
                                   v-if="selected_file.type.indexOf('image')  !== -1">
                                    <img v-bind:src="selected_file.path"/>
                                </a>


                                <video v-if="selected_file.type.indexOf('video')  !== -1"
                                       width="100%" height="auto" controls>
                                    <source v-bind:src="selected_file.path" type="video/mp4">
                                    <source v-bind:src="selected_file.path" type="video/ogg">
                                    <source v-bind:src="selected_file.path" type="video/webm">

                                    {{trans('dashboard::systems/media.video_support')}}
                                </video>


                                <audio v-if="selected_file.type.indexOf('audio')  !== -1"
                                       controls style="width:100%; margin-top:5px;">
                                    <source v-bind:src="selected_file.path" type="audio/ogg">
                                    <source v-bind:src="selected_file.path" type="audio/mpeg">

                                    {{trans('dashboard::systems/media.audio_support')}}
                                </audio>


                                <i v-if="selected_file.type == 'folder'" class="icon-folder-alt"></i>

                                <i v-if="selected_file.type.indexOf('text')  !== -1"
                                   class="icon-doc"></i>


                            </div>

                            <table class="table" v-bind:class="selected_file.type">
                                <tr>
                                    <td width="50%"><small class="text-muted">{{trans('dashboard::systems/media.fileinfo.title')}}:</small></td>
                                    <td>@{{selected_file.name}}</td>
                                </tr>
                                <tr>
                                    <td><small class="text-muted">{{trans('dashboard::systems/media.fileinfo.type')}}:</small></td>
                                    <td>@{{selected_file.type}}</td>
                                </tr>
                                <tr v-if="selected_file.type != 'folder'">
                                    <td><small class="text-muted">{{trans('dashboard::systems/media.fileinfo.size')}}:</small></td>
                                    <td>@{{selected_file.size}}</td>
                                </tr>
                                <tr v-if="selected_file.type != 'folder'">
                                    <td><small class="text-muted">{{trans('dashboard::systems/media.fileinfo.public_url')}}:</small></td>
                                    <td><a v-bind:href="selected_file.path"
                                           target="_blank">{{trans('dashboard::systems/media.fileinfo.click_here')}}</a></td>
                                </tr>
                                <tr v-if="selected_file.type != 'folder'">
                                    <td><small class="text-muted">{{trans('dashboard::systems/media.fileinfo.last_modified')}}:</small></td>
                                    <td>@{{selected_file.last_modified}}</td>
                                </tr>
                            </table>

                        </div>

                    </div>

                </div>

                <div class="nothingfound">
                    <div class="nofiles"></div>
                    <span>{{trans('dashboard::systems/media.no_files_here')}}</span>
                </div>

            </div>

            <!-- Move File Modal  -->
            <div class="modal fade modal-warning" id="move_file_modal">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;
                            </button>
                            <h4 class="modal-title"><i class="icon-cursor-move"></i>{{trans('dashboard::systems/media.move_file_folder')}}</h4>
                        </div>

                        <div class="modal-body">
                            <h4>{{trans('dashboard::systems/media.destination_folder')}}</h4>
                            <select id="move_folder_dropdown">

                                <option v-if="folders.length" value="/../">../</option>
                                <option v-for="dir in directories" v-bind:value="dir">@{{ dir }}</option>

                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('dashboard::systems/media.cancel')}}</button>
                            <button type="button" class="btn btn-warning" id="move_btn">{{trans('dashboard::systems/media.move')}}</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Move File Modal  -->

            <!-- Rename File Modal  -->
            <div class="modal fade modal-warning" id="rename_file_modal">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;
                            </button>
                            <h4 class="modal-title"><i class="fa fa-character"></i> {{trans('dashboard::systems/media.rename_file_folder')}}</h4>
                        </div>

                        <div class="modal-body">
                            <h4>{{trans('dashboard::systems/media.new_file_folder')}}</h4>
                            <input id="new_filename" class="form-control" type="text"
                                   v-model="new_filename">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('dashboard::systems/media.cancel')}}</button>
                            <button type="button" class="btn btn-warning" id="rename_btn">{{trans('dashboard::systems/media.rename')}}</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Move File Modal  -->

        </div><!-- #filemanager  -->

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
                            {{trans('dashboard::systems/media.add_new_folder')}}
                        </h4>
                    </div>

                    <div class="modal-body">
                        <input name="new_folder_name" id="new_folder_name" placeholder="New Folder Name"
                               class="form-control" value=""/>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('dashboard::systems/media.cancel')}}</button>
                        <button type="button" class="btn btn-info" id="new_folder_submit">
                            {{trans('dashboard::systems/media.add_new_folder')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
              <!-- End New Folder Modal  -->

              <!-- Delete File Modal  -->
        <div class="modal fade modal-danger" id="confirm_delete_modal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true">&times;
                        </button>
                        <h4 class="modal-title"><i class="icon-exclamation"></i>{{trans('dashboard::systems/media.delete')}}?</h4>
                    </div>

                    <div class="modal-body">
                        <h4>{{trans('dashboard::systems/media.sure_delete')}} '<span class="confirm_delete_name"></span>'</h4>
                        <h5 class="folder_warning"><i class="icon-exclamation"></i>
						{{trans('dashboard::systems/media.delete_folder_question')}}</h5>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('dashboard::systems/media.cancel')}}</button>
                        <button type="button" class="btn btn-danger" id="confirm_delete">{{trans('dashboard::systems/media.yes_delete')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
              <!-- End Delete File Modal  -->


    </div><!-- .page-content container-fluid  -->



    <input type="hidden" id="storage_path" value="{{ storage_path() }}">

@stop
