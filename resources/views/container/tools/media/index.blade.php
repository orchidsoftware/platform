@extends('dashboard::layouts.dashboard')


@section('title','Media')
@section('description','Filemanager')


@section('content')


    <style>
        .media-section .modal-footer {
            margin-top: 0;
        }

        .media-section .modal .modal-header .close {
            padding-bottom: 2px;
        }

        .media-section .modal-content {
            border: 0;
        }

        .media-section .modal-header {
            background: #21A9E1;
        }

        .media-section #confirm_delete_modal .modal-header {
            background: #E14421;
        }

        .media-section #move_file_modal .modal-header {
            background: #FC9A24;
        }

        .media-section .modal-header h4 {
            color: #fff;
        }

        .confirm_delete_name {
            color: #4DA7E8;
        }

        #move_btn {
            background: #FABE28;
            border: 1px solid #FABE28;
        }

        /**************************************************/
        /***				TOOLBAR CSS					***/
        /**************************************************/

        #toolbar {
            padding: 15px;
        }

        /**************************************************/
        /***				BREADCRUMB CSS				***/
        /**************************************************/

        .breadcrumb-container {
            position: relative;
        }

        .breadcrumb.filemanager {
            top: 0;
            background: #f0f0f0;
            border: 1px solid #E0E0E0;
            border-bottom: 0;
            border-radius: 0;
            padding-left: 20px;
            width: 100%;
            margin-top: 0;
            left: 0;
            margin-bottom: 0;
        }

        .breadcrumb.filemanager li {
            cursor: pointer;
            transition: color 0.1s linear;
            position: relative;
        }

        .breadcrumb.filemanager li:hover {
            color: #555;
        }

        .breadcrumb li .arrow {
            display: none;
            position: absolute;
            bottom: -14px;
            width: 12px;
            height: 12px;
            -ms-transform: rotate(45deg);
            -webkit-transform: rotate(45deg);
            transform: rotate(45deg);
            background: #f0f0f0;
            left: 50%;
            border-right: 1px solid #efefef;
            border-bottom: 1px solid #efefef;
        }

        .select2-display-none {
            z-index: 999999 !important;
        }

        .breadcrumb li:last-child .arrow {
            display: block;
        }

        .breadcrumb li:first-child .arrow {
            margin-left: -5px;
        }

        .breadcrumb li {
            color: #4DA7E8;
            cursor: pointer;
            font-weight: bold;
        }

        .breadcrumb li:last-child {
            color: #949494;
            cursor: pointer;
        }

        .breadcrumb-container .toggle {
            float: right;
            position: absolute;
            top: 11px;
            cursor: pointer;
            right: 5px;
            color: #bbb;
            transition: color 0.1s linear;
            overflow: visible;
        }

        .breadcrumb-container .toggle:hover {
            color: #aaa;
        }

        .breadcrumb-container .toggle span {
            font-size: 10px;
            text-transform: uppercase;
            float: left;
            top: 2px;
            position: relative;
            font-weight: bold;
            right: 10px;
        }

        .breadcrumb-container .toggle i {
            font-size: 18px;
            float: right;
            margin-right: 5px;
            position: relative;
            top: -4px;
        }

        .nothingfound {
            display: none;
        }

        #filemanager {
            position: relative;
            min-height: 200px;
        }

        #filemanager .loader {
            margin-top: 25px;
        }

        #filemanager #content {
            display: block;
            background: #fff;
        }

        .flex {
            display: flex;
            flex-wrap: wrap;
            border: 1px solid #E0E0E0;
            border-top: 0;
            min-height: calc(100vh - 260px);
        }

        .flex #left {
            flex: 4;
            position: relative;
            min-height: 230px;
        }

        .flex #left #no_files {
            display: none;
        }

        .flex #left #no_files h3 {
            text-align: center;
            margin-top: 55px;
            margin-bottom: 75px;
            color: #949494;
        }

        .flex #right {
            flex: 1;
            border-left: 1px solid #f1f1f1;
        }

        #right .right_details {
            display: block;
        }

        #right .right_none_selected {
            display: none;
            text-align: center;
        }

        #right .right_none_selected i {
            width: 100%;
            text-align: center;
            font-size: 30px;
            margin-left: 0;
            padding: 50px;
            display: block;
            background: #f9f9f9;
        }

        #right .right_none_selected p {
            text-align: center;
            color: #bbb;
            padding: 10px;
            border-bottom: 1px solid #f1f1f1;
        }

        #files {
            display: flex;
            list-style: none;
            width: 100%;
            margin: 0;
            padding: 0;
            flex-wrap: wrap;
            padding: 10px;
            position: relative;
            -webkit-touch-callout: none; /* iOS Safari */
            -webkit-user-select: none; /* Chrome/Safari/Opera */
            -khtml-user-select: none; /* Konqueror */
            -moz-user-select: none; /* Firefox */
            -ms-user-select: none; /* Internet Explorer/Edge */
            user-select: none;
        }

        #files li {
            flex: 1;
            width: 100%;
            min-width: 200px;
            max-width: 250px;
        }

        #files li .file_link {
            background: #eee;
            padding: 10px;
            margin: 10px;
            cursor: pointer;
            border-radius: 3px;
            border: 1px solid #ecf0f1;
            overflow: hidden;
            background: #f6f8f9;
            display: flex;
            height: 70px;
        }

        #files li .file_link .details {
            flex: 2;
            overflow: hidden;
            width: 100%;
        }

        #files li .file_link .details small {
            font-size: 11px;
            position: relative;
            top: -3px;
            font-weight: 300;
        }

        #files li .file_link .link_icon {
            flex: 1;
        }

        #files li .file_link img, #files li .file_link .img_icon {
            display: none;
        }

        #files li .file_link.image img, #files li .file_link.image .img_icon {
            display: block;
        }

        #files li .file_link.image img {
            height: 50px;
        }

        #files li .file_link.image .img_icon {
            width: 50px;
            height: 50px;
            display: block;
        }

        #files li .file_link.selected, #files li .file_link:hover {
            background: #23b7e5 !important;
            border-color: #15b3e4;
            color: #fff;
        }

        #files li .file_link.selected h4, #files li .file_link:hover h4 {
            color: #fff;
        }

        #files li .details h4 {
            margin-bottom: 2px;
            margin-top: 10px;
            max-height: 17px;
            height: 17px;
            overflow: hidden;
            font-size: 14px;
            text-overflow: ellipsis;
        }

        #files li .details.folder h4 {
            margin-top: 16px;
        }

        .file_link.folder i.icon {
            float: left;
            margin-left: 10px;
        }

        .file_link.folder .num_items {
            display: block;
        }

        .file_link .link_icon {
            text-align: center;
            padding-left: 0;
            margin-left: 0;
            margin-right: 5px;
        }

        .file_link .link_icon i {
            padding-left: 0;
            padding-right: 0;
            position: relative;
            top: 5px;
        }

        .file_link i.icon:before {
            font-size: 40px;
        }

        .detail_img {
            border-bottom: 1px solid #f1f1f1;
            background: #eee;
        }

        .detail_img img {
            width: 100%;
            height: auto;
            display: inline-block;
        }

        .detail_img i {
            display: block;
            width: 100%;
            text-align: center;
            font-size: 70px;
            margin-left: 0;
            padding: 30px;
            background: #f9f9f9;
        }

        .detail_img.folder i.fa-folder {
            display: block;
        }

        .detail_img.file i.fa-file {
            display: block;
        }

        .detail_img.image img {
            display: block;
        }

        .detail_info {
            padding: 10px;
        }

        .detail_info .selected_file_count, .detail_info.folder .selected_file_size {
            display: none;
        }

        .detail_info.folder .selected_file_count {
            display: block;
        }

        .detail_info span {
            display: block;
            clear: both;
        }

        .detail_info a {
            color: #4DA7E8;
        }

        .detail_info .selected_file_count, .detail_info .selected_file_size {
            padding-top: 0;
        }

        .detail_info h4 {
            float: left;
            color: #bbb;
            font-size: 13px;
            margin: 3px 8px 0 0;
            padding-bottom: 2px;
            font-weight: 300;
        }

        .detail_info p {
            float: left;
            color: #444;
            padding-bottom: 3px;
            font-size: 13px;
            font-weight: 400;
        }

        /********** file upload progress **********/

        #filemanager .progress {
            border-radius: 0;
            margin-bottom: 0;
        }

        #uploadProgress {
            display: none;
            background: #eee;
        }

        /********** end file upload progress **********/

        #file_loader {
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            background: rgba(255, 255, 255, 0.7);
            z-index: 9;
            text-align: center;
        }

        #file_loader #file_loader_inner {
            width: 60px;
            height: 60px;
            position: absolute;
            top: 50%;
            left: 50%;
            margin-left: -30px;
            margin-top: -30px;

        }

        #file_loader img {
            width: 80px;
            height: 80px;
            margin-top: 50px;
            opacity: 0.5;
            -webkit-animation: spin 1.2s ease-in-out infinite;
            -moz-animation: spin 1.2s ease-in-out infinite;
            animation: spin 1.2s ease-in-out infinite;

        }

        #file_loader p {
            margin-top: 40px;
            position: absolute;
            text-align: center;
            width: 100%;
            top: 50%;
            font-weight: 400;
            font-size: 12px;
        }

        @-moz-keyframes spin {
            100% {
                -moz-transform: rotate(360deg);
            }
        }

        @-webkit-keyframes spin {
            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
    </style>



    <div class="page-content container-fluid">
        <div class="row">
            <div class="">

                <div id="filemanager">

                    <div id="toolbar">
                        <div class="btn-group offset-right">
                            <button type="button" class="btn btn-info" id="upload"><i class="fa fa-upload"></i>
                                Upload
                            </button>
                            <button type="button" class="btn btn-info" id="new_folder"
                                    onclick="jQuery('#new_folder_modal').modal('show');"><i class="fa fa-folder"></i>
                                Add folder
                            </button>
                        </div>
                        <button type="button" class="btn btn-default" id="refresh"><i class="fa fa-refresh"></i>
                        </button>
                        <div class="btn-group offset-right">
                            <button type="button" class="btn btn-default" id="move"><i class="fa fa-move"></i> Move
                            </button>
                            <button type="button" class="btn btn-default" id="rename"><i class="fa fa fa-font"></i>
                                Rename
                            </button>
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
                            <ol class="breadcrumb filemanager">
                                <li data-folder="/" data-index="0"><span class="arrow"></span><strong>Media
                                        Library</strong></li>

                                <li v-for="(folder,index) in folders" v-bind:data-folder="folder"
                                    v-bind:data-index="index+1">
                                    <span class="arrow"></span>@{{ folder }}
                                </li>
                            </ol>

                            <div class="toggle"><span>Close</span><i class="fa fa-double-right"></i></div>
                        </div>
                        <div class="flex">

                            <div id="left">

                                <ul id="files">

                                    <li v-for="(file,index) in files.items">
                                        <div class="file_link" v-bind:data-folder="file.name" v-bind:data-index="index">
                                            <div class="link_icon">

                                                <div v-if="file.type.includes('image')" class="img_icon"
                                                     style="background-size: cover; background: no-repeat center center;display:inline-block; width:100%; height:100%;"
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
                                    <div class="detail_img" v-bind:class="selected_file.type">

                                        <img v-if="selected_file.type  === 'object' && selected_file.type.includes('image')"
                                             v-bind:src="selected_file.path"/>


                                        <video v-if="selected_file.type  === 'object' && selected_file.type.includes('video')"
                                               width="100%" height="auto" controls>
                                            <source v-bind:src="selected_file.path" type="video/mp4">
                                            <source v-bind:src="selected_file.path" type="video/ogg">
                                            <source v-bind:src="selected_file.path" type="video/webm">
                                            Your browser does not support the video tag.
                                        </video>


                                        <audio v-if="selected_file.type  === 'object' &&selected_file.type.includes('audio')"
                                               controls style="width:100%; margin-top:5px;">
                                            <source v-bind:src="selected_file.path" type="audio/ogg">
                                            <source v-bind:src="selected_file.path" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                        </audio>


                                        <i v-if="selected_file.type == 'folder'" class="fa fa-folder"></i>

                                        <i v-if="selected_file.type  === 'object' && selected_file.type != 'folder' && !selected_file.type.includes('audio') && !selected_file.type.includes('video') && !selected_file.type.includes('image')"
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
                                            class="selected_file_size">@{{selected_file.size}}</span></p></span>
                                            <span><h4>Public URL:</h4>
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

                    <!-- Move File Modal -->
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
                    <!-- End Move File Modal -->

                    <!-- Rename File Modal -->
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
                    <!-- End Move File Modal -->

                </div><!-- #filemanager -->

                <!-- New Folder Modal -->
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
                <!-- End New Folder Modal -->

                <!-- Delete File Modal -->
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
                <!-- End Delete File Modal -->

                <div id="dropzone"></div>
                <!-- Delete File Modal -->
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
                <!-- End Delete File Modal -->


            </div><!-- .row -->
        </div><!-- .col-md-12 -->
    </div><!-- .page-content container-fluid -->


    <input type="hidden" id="storage_path" value="{{ storage_path() }}">

    @push('scripts')
    <script type="text/javascript">


        console.log('test');

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


        console.log('test2');

        CSRF_TOKEN = $('meta[name="csrf_token"]').attr('content');


        var managerMedia = function (o) {
            var files = $('#files');
            var defaults = {
                baseUrl: "/admin"
            };
            var options = $.extend(true, defaults, o);
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
                            alert("Sweet Success!");

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

                $('.breadcrumb-container .toggle').click(function () {
                    $('.flex #right').toggle();
                    var toggle_text = $('.breadcrumb-container .toggle span').text();
                    $('.breadcrumb-container .toggle span').text(toggle_text == "Close" ? "Open" : "Close");
                    $('.breadcrumb-container .toggle .icon').toggleClass('fa-toggle-right').toggleClass('fa-toggle-left');
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
                            alert('successfully created ' + $('#new_folder_name').val(), "Sweet Success!");
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
                            alert('successfully deleted ' + manager.selected_file.name, "Sweet Success!");
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
                            alert('Successfully moved file/folder', "Sweet Success!");
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
                            alert('Successfully renamed file/folder', "Sweet Success!");
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
