<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

        <!-- Styles -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

        <link rel="stylesheet" href="https://cdn.plyr.io/1.5.18/plyr.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
        <link type="text/css" rel="stylesheet" href="{{ asset('/filemanager_assets/vendor/dmuploader/css/uploader.css') }}">
        <link type="text/css" rel="stylesheet" href="{{ asset('/filemanager_assets/css/filemanager.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.0.0/pnotify.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.0.0/pnotify.brighttheme.min.css">

        <link type="text/css" rel="stylesheet" href="{{ asset('/filemanager_assets/vendor/contextMenu/dist/jquery.contextMenu.css') }}">
        <link type="text/css" rel="stylesheet" href="{{ asset('/filemanager_assets/vendor/highlight/styles/agate.css') }}">
        {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

        @if( view()->exists('vendor.infinety.filemanager.modals') )
            @include('vendor.infinety.filemanager.modals')
        @else
            @include('filemanager::modals')
        @endif
    </head>
    <body>
        <div class="default-views default-dialog">
            <div class="panel panel-default customnav">
                <div class="panel-heading customnav">
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
                                <li><button class="btn btn-info btn-cons" id="single-upload"<i class="fa fa-upload"></i> Upload</button></li>
                                <li><button class="btn btn-info btn-cons" data-toggle="modal" data-target="#modalCreateFolder"><i class="fa fa-folder"></i> Create Folder</button></li>
                                <li class="home"><button class="btn btn-default"><i class="fa fa-home"></i></button></li>
                                <li class="refresh"><button class="btn btn-default"><i class="fa fa-refresh"></i></button></li>
                                <li class="move hide"><button class="btn btn-default"><i class="fa fa-arrows"></i> Move</button></li>
                                <li class="delete hide"><button class="btn btn-default"><i class="fa fa-trash"></i> Delete</button></li>
                                <li class="preview hide"><button class="btn btn-default"><i class="fa fa-eye"></i> Preview</button></li>
                                <li class="find">
                                    <div class="navbar-form navbar-left navbar-input-group">
                                        <div class="input-group form-search">
                                            <input type="text" class="form-control search-input" id="search" placeholder="&#61442; Search">
                                            <span class="input-group-addon input-group-search">
                                                <button class="btn btn-info" id="search-button" type="button"><i class="fa fa-search" aria-hidden="false"></i></button>
                                                <button class="btn btn-info hide" id="reset-button" type="button"><i class="fa fa-times" aria-hidden="false"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </li>
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
                                    <li class="list view-type"><button class="btn btn-default"><i class="fa fa-th-list"></i></button></li>
                                    <li class="grid view-type active"><button class="btn btn-default"><i class="fa fa-th"></i></button></li>
                                    <li class="big-grid view-type"><button class="btn btn-default"><i class="fa fa-th-large"></i></button></li>
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
        </div>

         <!-- JavaScripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}

        <script src="https://cdn.plyr.io/1.5.18/plyr.js" type="text/javascript"></script>
        <script src="{{ asset('/filemanager_assets/vendor/pdfobject.js') }}" type="text/javascript"></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery.fileDownload/1.4.2/jquery.fileDownload.min.js'></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.0.0/pnotify.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.0.0/pnotify.buttons.min.js" type="text/javascript"></script>
        <script src="{{ asset('/filemanager_assets/vendor/contextMenu/dist/jquery.contextMenu.js') }}" type="text/javascript"></script>
        <script src="{{ asset('/filemanager_assets/vendor/contextMenu/dist/jquery.ui.position.min.js') }}" type="text/javascript"></script>

        <script src="{{ asset('/filemanager_assets/vendor/highlight/highlight.pack.js') }}" type="text/javascript"></script>

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
    </body>
</html>