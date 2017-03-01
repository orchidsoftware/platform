
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('admin_theme/assets/plugins/boostrapv3/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_theme/assets/plugins/font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_theme/assets/plugins/jquery-scrollbar/jquery.scrollbar.css') }}" rel="stylesheet" type="text/css" media="screen" />
    <link href="{{ asset('admin_theme/assets/plugins/pnotify/pnotify.custom.css') }}" rel="stylesheet" type="text/css" media="screen" />
    <!-- BEGIN Pages CSS-->
    <link href="{{ asset('admin_theme/pages/css/pages-icons.css') }}" rel="stylesheet" type="text/css">
    <link class="main-stylesheet" href="{{ asset('admin_theme/pages/css/pages.css') }}" rel="stylesheet" type="text/css" />
    <!--[if lte IE 9]>
    <link href="pages/css/ie9.css" rel="stylesheet" type="text/css" />
    <![endif]-->
    <script type="text/javascript">
        window.onload = function()
        {
            // fix for windows 8
            if (navigator.appVersion.indexOf("Windows NT 6.2") != -1)
                document.head.innerHTML += '<link rel="stylesheet" type="text/css" href="pages/css/windows.chrome.fix.css" />'
        }
    </script>
    <link class="main-stylesheet" href="{{ asset('admin_theme/assets/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.plyr.io/1.5.18/plyr.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <link type="text/css" rel="stylesheet" href="{{ asset('/filemanager_assets/vendor/dmuploader/css/uploader.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('/filemanager_assets/css/filemanager.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('/filemanager_assets/vendor/contextMenu/dist/jquery.contextMenu.css') }}">

    @include('filemanager::modals')
    <div class="panel panel-default">
        <div class="panel-heading">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <ul class="nav navbar-nav">
                        <div class="upload_div hide">
                            <input type="file" name="files[]" id="single-upload-file" multiple="multiple" title="Click to add Files">
                        </div>
                        <li><button class="btn btn-complete btn-cons" id="single-upload"<i class="fa fa-upload"></i> Upload</button></li>
                        <li><button class="btn btn-complete btn-cons" data-toggle="modal" data-target="#modalCreateFolder"><i class="fa fa-folder"></i> Create Folder</button></li>
                        <li class="home"><button class="btn "><i class="fa fa-home"></i></button></li>
                        <li class="refresh"><button class="btn "><i class="fa fa-refresh"></i></button></li>
                        <li class="move"><button class="btn"><i class="fa fa-arrows"></i> Move</button></li>
                        <li class="delete"><button class="btn"><i class="fa fa-trash"></i> Delete</button></li>
                        <li class="preview"><button class="btn"><i class="fa fa-eye"></i> Preview</button></li>
                    </ul>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <form class="navbar-form navbar-right hide" role="search">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Search">
                            </div>
                            <button type="submit" class="btn btn-default">Submit</button>
                        </form>
                        <ul class="nav navbar-nav navbar-right views">
                            <li class="list view-type"><button class="btn "><i class="fa fa-th-list"></i></button></li>
                            <li class="grid view-type active"><button class="btn "><i class="fa fa-th"></i></button></li>
                            <li class="big-grid view-type"><button class="btn "><i class="fa fa-th-large"></i></button></li>
                        </ul>

                        <ul class="nav navbar-nav navbar-right">

                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
        </div>
        <div class="panel-body" >
            <div class="row">
                {{--<div class="col-md-2">--}}
                {{--</div>--}}
                <div class="col-md-12">
                    <ol class="breadcrumb">
                        <?php $home = explode('/', config('filemanager.homePath')); ?>
                        <li class="active" data-folder="Home"><a href="#">{{ last($home) }}</a></li>
                    </ol>
                </div>
            </div>
            {{--<div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar" role="navigation">--}}
                {{--<h5>Display</h5>--}}
                {{--<ul class="list-group">--}}
                    {{--<li class="list-group-item filter active" data-filter="all"><i class="fa fa-diamond"></i>All files</li>--}}
                    {{--<li class="list-group-item filter" data-filter="image"><i class="fa fa-image"></i>Images</li>--}}
                    {{--<li class="list-group-item filter" data-filter="video"><i class="fa fa-video-camera"></i>Video</li>--}}
                    {{--<li class="list-group-item filter" data-filter="audio"><i class="fa fa-music"></i>Audio</li>--}}
                    {{--<li class="list-group-item filter" data-filter="documents"><i class="fa fa-file"></i>Documents</li>--}}
                {{--</ul>--}}
                {{--<h5>Order by</h5>--}}
                {{--<select class="cs-select cs-skin-slide full-width" data-init-plugin="cs-select" id="sort-by">--}}
                    {{--<option value="mime">Type</option>--}}
                    {{--<option value="name">Alpha</option>--}}
                    {{--<option value="size">Size</option>--}}
                {{--</select>--}}
            {{--</div>--}}
            {{--<li class="list-group-item filter hide active" data-filter="image"><i class="fa fa-image"></i>Images</li>--}}
            <div class="col-xs-12">
                <div class="col-xs-12">
                    <div class="row upload_div" id="files_container">
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script src="{{ asset('admin_theme/assets/plugins/jquery/jquery-1.11.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin_theme/assets/plugins/classie/classie.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin_theme/assets/plugins/pnotify/pnotify.custom.js') }}"></script>
    <script src="{{ asset('admin_theme/assets/plugins/modernizr.custom.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin_theme/assets/plugins/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin_theme/assets/plugins/boostrapv3/js/bootstrap.min.js') }}" type="text/javascript"></script>

    <script src="https://cdn.plyr.io/1.5.18/plyr.js" type="text/javascript"></script>
    <script src="{{ asset('/filemanager_assets/vendor/pdfobject.js') }}" type="text/javascript"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <script src="{{ asset('/filemanager_assets/vendor/contextMenu/dist/jquery.contextMenu.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/filemanager_assets/vendor/contextMenu/dist/jquery.ui.position.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('/filemanager_assets/vendor/dmuploader/js/dmuploader.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/filemanager_assets/vendor/dmuploader/js/gallery.js') }}" type="text/javascript"></script>


    <script>
        (function(d, p){
            var a = new XMLHttpRequest(),
                    b = d.body;
            a.open('GET', p, true);
            a.send();
            a.onload = function() {
                var c = d.createElement('div');
                c.setAttribute('hidden', '');
                c.innerHTML = a.responseText;
                b.insertBefore(c, b.childNodes[0]);
            };
        })(document, 'https://cdn.plyr.io/1.5.18/sprite.svg');

    </script>
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            /**
             * Set global variables
             */

            url_process = "{{ url(config('filemanager.defaultRoute', 'admin/filemanager').'/get_folder') }}";
            url_upload  = "{{ url(config('filemanager.defaultRoute', 'admin/filemanager').'/uploadFile') }}";
            url_cfolder = "{{ url(config('filemanager.defaultRoute', 'admin/filemanager').'/createFolder') }}";
            url_delete  = "{{ url(config('filemanager.defaultRoute', 'admin/filemanager').'/delete') }}";
            url_download = "{{ url(config('filemanager.defaultRoute', 'admin/filemanager').'/download') }}";
            url_preview  = "{{ url(config('filemanager.defaultRoute', 'admin/filemanager').'/preview') }}";
            url_move  = "{{ url(config('filemanager.defaultRoute', 'admin/filemanager').'/move') }}";
            url_rename  = "{{ url(config('filemanager.defaultRoute', 'admin/filemanager').'/rename') }}";
            url_optimize  = "{{ url(config('filemanager.defaultRoute', 'admin/filemanager').'/optimize') }}";
            optimizeOption = {{ (config('filemanager.optimizeImages', false)) == 1 ? 'true' : 'false'  }};
            image_path  = "{{ asset('/') }}";
            homeFolder  = "{{ last($home) }}";
            path_folder = "";
            current_file = null;
            cutted_file = null;
            temp_folder = null;
            globalFilter = "{{ (isset($_GET['filter'])) ? $_GET['filter'] : 'image' }}";
            typeCallback = "{{ (isset($_GET['type'])) ? $_GET['type'] : 'featured' }}";
            editorId =  "{{ (isset($_GET['editor'])) ? $_GET['editor'] : null }}";
            /**
             * Languages variables
             */

            text_upload = "{!! trans('kgallery.upload.info') !!}";


        });
    </script>
    <script src="{{ asset('filemanager_assets/js/filemanager.js') }}" type="text/javascript"></script>
    <script src="{{ asset('filemanager_assets/js/upload.js') }}" type="text/javascript"></script>
