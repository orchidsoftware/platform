@extends('dashboard::layouts.dashboard')


@section('title','Media')
@section('description','Filemanager')


@section('content')


    <div class="page-content container-fluid">
        <div class="row">
            <div class="">

                <div id="filemanager">

                    <div id="toolbar">
                        <div class="btn-group">
                            <button type="button" class="btn btn-info" id="upload"><i class="fa fa-upload"></i>
                                Upload
                            </button>
                            <button type="button" class="btn btn-default" id="new_folder"
                                    onclick="jQuery('#new_folder_modal').modal('show');"><i class="fa fa-folder"></i>
                                Add folder
                            </button>
                        </div>
                        <button type="button" class="btn btn-default" id="refresh"><i class="fa fa-refresh"></i>
                        </button>
                        <div class="btn-group">
                            {{-- <button type="button" class="btn btn-default" id="move"><i class="fa fa-move"></i> Move
                            </button> --}}
                            {{--<button type="button" class="btn btn-default" id="rename"><i class="fa fa fa-font"></i>
                                Rename
                            </button> --}}
                            <button type="button" class="btn btn-default" id="delete"><i class="fa fa-trash"></i>
                                Delete
                            </button>
                        </div>
                    </div>

                    <div id="uploadPreview" style="display:none;"></div>

                    <div id="uploadProgress" class="progress active progress-striped">
                        <div class="progress-bar progress-bar-success" style="width: 0"></div>
                    </div>

                    <div id="content">


                        <div class="breadcrumb-container">
                            <ol class="breadcrumb filemanager b-t small">
                                <li data-folder="/" data-index="0"><span class="arrow"></span>
                                    <span>Media Library</span>
                                </li>

                                <li v-for="(folder,index) in folders" v-bind:data-folder="folder"
                                    v-bind:data-index="index+1">
                                    <span class="arrow"></span>@{{ folder }}
                                </li>
                            </ol>

                        </div>
                        <div class="flex">

                            <div id="left">

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

                                                <i v-if="file.type  === 'object' && file.type.includes('video')"
                                                   class="icon fa fa-video"></i>

                                                <i v-if="file.type.includes('audio')" class="icon fa fa-music"></i>

                                                <i v-if="file.type == 'folder'" class="icon fa fa-folder"></i>

                                                <i v-if="file.type != 'folder' && !file.type.includes('image') && !file.type.includes('video') && !file.type.includes('audio')"
                                                   class="icon fa fa-file-text"></i>

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
                                    <p>LOADING YOUR MEDIA FILES</p>
                                </div>

                                <div id="no_files">
                                    <h3><i class="fa fa-meh"></i> No files in this folder.</h3>
                                </div>

                            </div>

                            <div id="right">
                                <div class="right_none_selected">
                                    <i class="fa fa-cursor"></i>
                                    <p>No File or Folder Selected</p>
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
                                            Your browser does not support the video tag.
                                        </video>


                                        <audio v-if="selected_file.type.indexOf('audio')  !== -1"
                                               controls style="width:100%; margin-top:5px;">
                                            <source v-bind:src="selected_file.path" type="audio/ogg">
                                            <source v-bind:src="selected_file.path" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                        </audio>


                                        <i v-if="selected_file.type == 'folder'" class="fa fa-folder"></i>

                                        <i v-if="selected_file.type.indexOf('text')  !== -1"
                                           class="fa fa-file-text-o"></i>


                                    </div>
                                    <div class="detail_info" v-bind:class="selected_file.type">
							<span><h4>Title:</h4>
                                       <p>@{{selected_file.name}}</p></span>
                                        <span><h4>Type:</h4>
                                            <p>@{{selected_file.type}}</p></span>
                                        <div v-if="selected_file.type != 'folder'">
								<span><h4>Size:</h4>
								<p><span class="selected_file_count">@{{ selected_file.items }} item(s)</span><span
                                            class="selected_file_size">@{{selected_file.size}}</span></p>
                                    <span><h4>Public URL:</h4></span>
								<p><a v-bind:href="selected_file.path" target="_blank">Click Here</a></p></span>
                                            <span><h4>Last Modified:</h4>
								<p>@{{selected_file.last_modified}}</p></span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="nothingfound">
                            <div class="nofiles"></div>
                            <span>No files here.</span>
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
                                    <h4 class="modal-title"><i class="fa fa-move"></i> Move File/Folder</h4>
                                </div>

                                <div class="modal-body">
                                    <h4>Destination Folder</h4>
                                    <select id="move_folder_dropdown">

                                        <option v-if="folders.length" value="/../">../</option>
                                        <option v-for="dir in directories" v-bind:value="dir">@{{ dir }}</option>

                                    </select>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-warning" id="move_btn">Move</button>
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
                                    <h4 class="modal-title"><i class="fa fa-character"></i> Rename File/Folder</h4>
                                </div>

                                <div class="modal-body">
                                    <h4>New File/Folder Name</h4>
                                    <input id="new_filename" class="form-control" type="text"
                                           v-model="selected_file.name">
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-warning" id="rename_btn">Rename</button>
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
                                <h4 class="modal-title"><i class="fa fa-folder"></i> Add New Folder</h4>
                            </div>

                            <div class="modal-body">
                                <input name="new_folder_name" id="new_folder_name" placeholder="New Folder Name"
                                       class="form-control" value=""/>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-info" id="new_folder_submit">Create New Folder
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
                                <h4 class="modal-title"><i class="fa fa-warning"></i> Are You Sure</h4>
                            </div>

                            <div class="modal-body">
                                <h4>Are you sure you want to delete '<span class="confirm_delete_name"></span>'</h4>
                                <h5 class="folder_warning"><i class="fa fa-warning"></i> Deleting a folder will remove
                                    all files and folders contained inside</h5>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-danger" id="confirm_delete">Yes, Delete it!
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Delete File Modal  -->

                <div id="dropzone"></div>
                <!-- Delete File Modal  -->
                <div class="modal fade" id="upload_files_modal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;
                                </button>
                                <h4 class="modal-title"><i class="fa fa-warning"></i> Drag and drop files or click
                                    below to upload</h4>
                            </div>

                            <div class="modal-body">

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal">All done</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Delete File Modal  -->


            </div><!-- .row  -->
        </div><!-- .col-md-12  -->
    </div><!-- .page-content container-fluid  -->



    <input type="hidden" id="storage_path" value="{{ storage_path() }}">

    @push('scripts')
    <script type="text/javascript">

        const manager = new Vue({
            el: '#filemanager',
            data: {
                files: '',
                folders: [],
                selected_file: '',
                directories: [],
            },
            mounted: function () {
                console.log('Ready manager');
            }
        });

        CSRF_TOKEN = $('meta[name="csrf_token"]').attr('content');

        var managerMedia = function (o) {
            var files = $('#files');
            var options = $.extend(true, {}, o);
            this.init = function () {
                $("#upload").dropzone({
                    url: options.baseUrl + "/media/upload",
                    previewsContainer: "#uploadPreview",
                    totaluploadprogress: function (uploadProgress, totalBytes, totalBytesSent) {
                        $('#uploadProgress .progress-bar').css('width', uploadProgress + '%');
                        if (uploadProgress == 100) {
                            $('#uploadProgress').delay(1500).slideUp(function () {
                                $('#uploadProgress .progress-bar').css('width', '0%');
                            });

                        }
                    },
                    processing: function () {
                        $('#uploadProgress').fadeIn();
                    },
                    sending: function (file, xhr, formData) {
                        formData.append("_token", CSRF_TOKEN);
                        formData.append("upload_path", manager.files.path);
                    },
                    success: function (e, res) {
                        if (res.success) {
                            //alert("Sweet Success!");

                        } else {
                            alert("Whoopsie!");
                        }
                    },
                    error: function (e, res, xhr) {
                        alert("Whoopsie");
                    },
                    queuecomplete: function () {
                        getFiles(manager.folders);
                    }
                });

                getFiles('/');


                files.on("dblclick", "li .file_link", function () {
                    if (!$(this).children('.details').hasClass('folder')) {
                        return false;
                    }
                    manager.folders.push($(this).data('folder'));
                    getFiles(manager.folders);
                });

                files.on("click", "li", function (e) {
                    var clicked = e.target;
                    if (!$(clicked).hasClass('file_link')) {
                        clicked = $(e.target).closest('.file_link');
                    }
                    setCurrentSelected(clicked);
                });

                $('.breadcrumb').on("click", "li", function () {
                    var index = $(this).data('index');
                    manager.folders = manager.folders.splice(0, index);
                    getFiles(manager.folders);
                });


                //********** Add Keypress Functionality **********//
                var isBrowsingFiles = null,
                    fileBrowserActive = function (el) {
                        el = el instanceof jQuery ? el : $(el);
                        if ($.contains(files.parent()[0], el[0])) {
                            return true;
                        } else {
                            //$(document).off('click');
                            //console.log('testt');
                            //return false;
                        }
                    },
                    handleFileBrowserStatus = function (target) {
                        isBrowsingFiles = fileBrowserActive(target);
                    };

                files.on('click', function (event) {
                    if (!isBrowsingFiles) {
                        $(document).on('click', function (e) {
                            handleFileBrowserStatus(e.target);
                        });
                    } else {
                        handleFileBrowserStatus(event.target);
                    }
                });

                $(document).keydown(function (e) {
                    var isKeyControl = e.which >= 37 && e.which <= 40;
                    if (!isBrowsingFiles && isKeyControl) {
                        return false;
                    } else if (isKeyControl && isBrowsingFiles) {
                        e.preventDefault();
                    }
                    var curSelected = $('#files li .selected').data('index');
                    // left key
                    if ((e.which == 37 || e.which == 38) && parseInt(curSelected)) {
                        newSelected = parseInt(curSelected) - 1;
                        setCurrentSelected($('*[data-index="' + newSelected + '"]'));
                    }
                    // right key
                    if ((e.which == 39 || e.which == 40) && parseInt(curSelected) < manager.files.items.length - 1) {
                        newSelected = parseInt(curSelected) + 1;
                        setCurrentSelected($('*[data-index="' + newSelected + '"]'));
                    }
                    // enter key
                    if (e.which == 13) {
                        if (!$('#new_folder_modal').is(':visible') && !$('#move_file_modal').is(':visible') && !$('#confirm_delete_modal').is(':visible')) {
                            manager.folders.push($('#files li .selected').data('folder'));
                            getFiles(manager.folders);
                        }
                        if ($('#confirm_delete_modal').is(':visible')) {
                            $('#confirm_delete').trigger('click');
                        }
                    }
                });
                //********** End Keypress Functionality **********//


                /********** TOOLBAR BUTTONS **********/
                $('#refresh').click(function () {
                    getFiles(manager.folders);
                });

                $('#new_folder_modal').on('shown.bs.modal', function () {
                    $("#new_folder_name").focus();
                });

                $('#new_folder_name').keydown(function (e) {
                    if (e.which == 13) {
                        $('#new_folder_submit').trigger('click');
                    }
                });

                $('#move_file_modal').on('hidden.bs.modal', function () {
                    $("#s2id_move_folder_dropdown").select2("close");
                });

                $('#new_folder_submit').click(function () {
                    console.log('test');
                    new_folder_path = manager.files.path + '/' + $('#new_folder_name').val();
                    $.post(options.baseUrl + '/media/new_folder', {
                        new_folder: new_folder_path,
                        _token: CSRF_TOKEN
                    }, function (data) {
                        if (data.success == true) {
                            //alert('successfully created ' + $('#new_folder_name').val(), "Sweet Success!");
                            getFiles(manager.folders);
                        } else {
                            alert("Whoops!");
                        }
                        $('#new_folder_name').val('');
                        $('#new_folder_modal').modal('hide');
                    });
                });

                $('#delete').click(function () {
                    if (manager.selected_file.type == 'directory') {
                        $('.folder_warning').show();
                    } else {
                        $('.folder_warning').hide();
                    }
                    $('.confirm_delete_name').text(manager.selected_file.name);
                    $('#confirm_delete_modal').modal('show');
                });

                $('#confirm_delete').click(function () {

                    $.post(options.baseUrl + '/media/delete_file_folder', {
                        folder_location: manager.folders,
                        file_folder: manager.selected_file.name,
                        type: manager.selected_file.type,
                        _token: CSRF_TOKEN
                    }, function (data) {
                        if (data.success == true) {
                            //alert('successfully deleted ' + manager.selected_file.name, "Sweet Success!");
                            getFiles(manager.folders);
                            $('#confirm_delete_modal').modal('hide');
                        } else {
                            alert("Whoops!");
                        }
                    });
                });

                $('#move').click(function () {
                    $('#move_file_modal').modal('show');
                });

                $('#rename').click(function () {
                    if (typeof(manager.selected_file) !== 'undefined') {
                        $('#rename_file').val(manager.selected_file.name);
                    }
                    $('#rename_file_modal').modal('show');
                });

                $('#move_folder_dropdown').keydown(function (e) {
                    if (e.which == 13) {
                        $('#move_btn').trigger('click');
                    }
                });

                $('#move_btn').click(function () {
                    source = manager.selected_file.name;
                    destination = $('#move_folder_dropdown').val() + '/' + manager.selected_file.name;
                    $('#move_file_modal').modal('hide');
                    $.post(options.baseUrl + '/media/move_file', {
                        folder_location: manager.folders,
                        source: source,
                        destination: destination,
                        _token: CSRF_TOKEN
                    }, function (data) {
                        if (data.success == true) {
                            //alert('Successfully moved file/folder', "Sweet Success!");
                            getFiles(manager.folders);
                        } else {
                            alert(data.error, "Whoops!");
                        }
                    });
                });

                $('#rename_btn').click(function () {
                    source = manager.selected_file.path;
                    filename = manager.selected_file.name;
                    new_filename = $('#new_filename').val();
                    $('#rename_file_modal').modal('hide');
                    $.post(options.baseUrl + '/media/rename_file', {
                        folder_location: manager.folders,
                        filename: filename,
                        new_filename: new_filename,
                        _token: CSRF_TOKEN
                    }, function (data) {
                        if (data.success == true) {
                            //alert('Successfully renamed file/folder', "Sweet Success!");
                            getFiles(manager.folders);
                        } else {
                            alert(data.error, "Whoops!");
                        }
                    });
                });

                // $('#upload').click(function(){
                // 	$('#upload_files_modal').modal('show');
                // });
                /********** END TOOLBAR BUTTONS **********/

                manager.$watch('files', function (newVal, oldVal) {
                    setCurrentSelected($('*[data-index="0"]'));
                    $('#filemanager #content #files').hide();
                    $('#filemanager #content #files').fadeIn('fast');
                    $('#filemanager .loader').fadeOut(function () {

                        $('#filemanager #content').fadeIn();
                    });

                    if (newVal.items.length < 1) {
                        $('#no_files').show();
                    } else {
                        $('#no_files').hide();
                    }
                });

                manager.$watch('directories', function (newVal, oldVal) {
                    if ($("#move_folder_dropdown").select2()) {
                        $("#move_folder_dropdown").select2('destroy');
                    }
                    $("#move_folder_dropdown").select2();
                });

                manager.$watch('selected_file', function (newVal, oldVal) {
                    if (typeof(newVal) == 'undefined') {
                        $('.right_details').hide();
                        $('.right_none_selected').show();
                        $('#move').attr('disabled', true);
                        $('#delete').attr('disabled', true);
                    } else {
                        $('.right_details').show();
                        $('.right_none_selected').hide();
                        $('#move').removeAttr("disabled");
                        $('#delete').removeAttr("disabled");
                    }
                });

                function getFiles(folders) {
                    if (folders != '/') {
                        var folder_location = '/' + folders.join('/');
                    } else {
                        var folder_location = '/';
                    }
                    $('#file_loader').fadeIn();
                    $.post(options.baseUrl + '/media/files', {
                        folder: folder_location,
                        _token: CSRF_TOKEN,
                        _token: CSRF_TOKEN
                    }, function (data) {
                        $('#file_loader').hide();
                        manager.files = data;
                        files.trigger('click');
                        for (var i = 0; i < manager.files.items.length; i++) {
                            if (typeof(manager.files.items[i].size) != undefined) {
                                manager.files.items[i].size = bytesToSize(manager.files.items[i].size);
                            }
                        }
                    });

                    // Add the latest files to the folder dropdown
                    var all_folders = '';
                    $.post(options.baseUrl + '/media/directories', {
                        folder_location: manager.folders,
                        _token: CSRF_TOKEN
                    }, function (data) {
                        manager.directories = data;
                    });

                }

                function setCurrentSelected(cur) {
                    $('#files li .selected').removeClass('selected');
                    $(cur).addClass('selected');
                    manager.selected_file = manager.files.items[$(cur).data('index')];
                }

                function bytesToSize(bytes) {
                    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
                    if (bytes == 0) return '0 Bytes';
                    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                    return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
                }
            }
        };

        var media = new managerMedia({
            baseUrl: "{{ route('dashboard.index')}}/tools"
        });
        $(function () {
            media.init();
        });
    </script>
    @endpush
@stop
