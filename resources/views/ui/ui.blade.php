@extends('platform::layouts.dashboard')

@section('title',trans('platform::systems/settings.title'))
@section('description', trans('platform::systems/settings.description'))

@section('navbar')

@stop

@section('aside')


@endsection


@section('content')

 {{--
    <div class="modal-over" style="background: #1d2531;z-index: 50000;">
        <div class="v-center" style="height: 100vh">
            <div class="text-white center text-center">
                <h2>Пожалуйста обновите страницу</h2>
                <p class="text-muted">Вы слишком долго отсутствовали</p>
            </div>
        </div>
    </div>
--}}

    <div id="Typography">
        <div class="bg-light lter b-b wrapper-md">
            <h1 class="m-n font-thin h3">Typography</h1>
        </div>

        <div class="container">
            <div class="wrapper-md">

                    <div class="row">
                        <!-- headings -->
                        <div class="col-sm-3">
                            <h4 class="sub-title">Headings</h4>
                            <h1>H1 Heading</h1>
                            <h2>H2 Heading</h2>
                            <h3>H3 Heading</h3>
                            <h4>H4 Heading</h4>
                            <h5>H5 Heading</h5>
                            <h6>H6 Heading</h6>
                        </div>
                        <!-- / headings -->

                        <!-- paragraphs -->
                        <div class="col-sm-5">
                            <h4 class="sub-title">Paragraphs</h4>
                            <p class="Lead"><strong>Large Paragraph ( Lead )</strong>. Vivamus sollicitudin ligula ut ante bibendum, et sollicitudin sem ultricies. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
                            <p><strong>Regular Paragraph</strong>. Vivamus sollicitudin ligula ut ante bibendum, et sollicitudin sem ultricies. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
                            <p class="text-sm"><strong>Small Paragraph</strong>. Vivamus sollicitudin ligula ut ante bibendum, et sollicitudin sem ultricies. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
                            <p class="text-xs"><strong>Extra Small Paragraph</strong>. Vivamus sollicitudin ligula ut ante bibendum, et sollicitudin sem ultricies. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
                        </div>
                        <!-- / paragraphs -->

                        <!-- lists -->
                        <div class="col-sm-4">
                            <h4 class="sub-title">Lists</h4>
                            <ul class="list-featured space-bottom-20">
                                <li>Aliquam molestie quam in tincidunt accumns</li>
                                <li>Morbi quis neque non nisl egestas laoreet</li>
                                <li>Vestibulum nisi nibh, pulvinar sit amet lacinia</li>
                                <li>Mauris pretium elit ac facilisis mollis posuere</li>
                                <li>Mauris vitae magna in dolor porta aliquam</li>
                            </ul>
                            <ol>
                                <li>Aliquam molestie quam in tincidunt accumns</li>
                                <li>Morbi quis neque non nisl egestas laoreet</li>
                                <li>Vestibulum nisi nibh, pulvinar sit amet</li>
                                <li>Mauris pretium elit ac facilisis mollis</li>
                                <li>Mauris vitae magna in dolor porta aliquam</li>
                            </ol>
                        </div>
                        <!-- / lists -->
                    </div><!-- / row -->

                          <!-- titles -->
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="page-header text-left">
                                <h2>TITLE LEFT</h2>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="page-header text-center">
                                <h2>TITLE CENTER</h2>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="page-header text-right">
                                <h2>TITLE RIGHT</h2>
                            </div>
                        </div>
                    </div><!-- / row -->

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="page-header wsub text-left">
                                <h2>Title with Subtitle</h2>
                            </div>
                            <h4 class="sub-title">Subtitle Here...</h4>
                        </div>
                    </div><!-- / row -->
                          <!-- / titles -->

                    <div class="row">
                        <!-- text colors -->
                        <div class="col-sm-5">
                            <h4 class="sub-title">Text Colors</h4>
                            <p class="text-default"><strong>Default</strong>. Aliquam molestie quam in tincidunt accumsan</p>
                            <p class="text-primary"><strong>Primary</strong>. Morbi quis neque non nisl egestas laoreet</p>
                            <p class="text-success"><strong>Success</strong>. Vestibulum nisi nibh, pulvinar sit amet lacinia</p>
                            <p class="text-info"><strong>Info</strong>. Mauris pretium elit ac facilisis mollis posuere</p>
                            <p class="text-warning"><strong>Warning</strong>. Mauris vitae magna in dolor porta aliquam</p>
                            <p class="text-danger"><strong>Danger</strong>. Mauris vitae magna in dolor porta aliquam</p>
                        </div>
                        <!-- / text colors -->

                        <!-- text backgrounds -->
                        <div class="col-sm-7">
                            <h4 class="sub-title">Text Backgrounds</h4>
                            <p class="line-height-30"><span class="bg-default">Pellentesque iaculis</span> nisl vitae ligula volutpat, sit amet rhoncus nisl posuere. Vestibulum vel nisi euismod, <span class="bg-primary">commodo felis fermentum,</span> fringilla ex. Fusce vel mattis quam, id bibendum leo. Vivamus sollicitudin ligula ut ante bibendum, et <span class="bg-success">sollicitudin sem ultricies.</span> Interdum et malesuada <span class="bg-info">fames ac ante</span> ipsum primis in faucibus. Praesent laoreet ultrices tortor <span class="bg-warning">eget sollicitudin.</span> Vestibulum quis egestas mauris. Class aptent taciti sociosqu ad litora torquent per conubia nostra, <span class="bg-danger">per inceptos</span> himenaeos.</p>
                        </div>
                        <!-- / text backgrounds -->
                    </div><!-- / row -->

                          <!-- blockquotes -->
                    <div class="row">
                        <div class="col-sm-6">
                            <h4 class="sub-title">Blockquotes</h4>
                            <blockquote>
                                <p>Quisque ut lorem tristique, vehicula nunc eget, semper mi. Proin urna ipsum, pulvinar et turpis et, malesuada vehicula urna. Sed eget venenatis nunc.</p>
                                <cite>- James Doe</cite>
                            </blockquote>
                        </div>

                        <div class="col-sm-6">
                            <h4 class="sub-title">&nbsp;</h4>
                            <blockquote class="blockquote-reverse">
                                <p>Quisque ut lorem tristique, vehicula nunc eget, semper mi. Proin urna ipsum, pulvinar et turpis et, malesuada vehicula urna. Sed eget venenatis nunc.</p>
                                <cite>- James Doe</cite>
                            </blockquote>
                        </div>
                    </div><!-- / row -->
                          <!-- / blockquotes -->

                          <!-- 4col text blocks -->
                    <h4 class="sub-title space-left">Text-Blocks</h4>
                    <div class="row space-bottom-2x">
                        <div class="col-sm-3">
                            <p><strong>One Fourth.</strong> Vivamus sollicitudin ligula ut ante bibendum, et sollicitudin sem ultricies. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
                        </div>
                        <div class="col-sm-3">
                            <p><strong>One Fourth.</strong> Vivamus sollicitudin ligula ut ante bibendum, et sollicitudin sem ultricies. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
                        </div>
                        <div class="col-sm-3">
                            <p><strong>One Fourth.</strong> Vivamus sollicitudin ligula ut ante bibendum, et sollicitudin sem ultricies. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
                        </div>
                        <div class="col-sm-3">
                            <p><strong>One Fourth.</strong> Vivamus sollicitudin ligula ut ante bibendum, et sollicitudin sem ultricies. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
                        </div>
                    </div><!-- / row -->
                          <!-- / 4col text blocks -->

                          <!-- 3col text blocks -->
                    <div class="row space-bottom-2x">
                        <div class="col-sm-4">
                            <p><strong>One Third.</strong> Phasellus lobortis elit sed cursus ornare. Phasellus ut elit at nisl fringilla commodo nec non neque. Aliquam sed sagittis lorem, nec tempus lectus. Duis quis sollicitudin magna. Suspendisse sit amet orci venenatis</p>
                        </div>
                        <div class="col-sm-4">
                            <p><strong>One Third.</strong> Phasellus lobortis elit sed cursus ornare. Phasellus ut elit at nisl fringilla commodo nec non neque. Aliquam sed sagittis lorem, nec tempus lectus. Duis quis sollicitudin magna. Suspendisse sit amet orci venenatis</p>
                        </div>
                        <div class="col-sm-4">
                            <p><strong>One Third.</strong> Phasellus lobortis elit sed cursus ornare. Phasellus ut elit at nisl fringilla commodo nec non neque. Aliquam sed sagittis lorem, nec tempus lectus. Duis quis sollicitudin magna. Suspendisse sit amet orci venenatis</p>
                        </div>
                    </div><!-- / row -->
                          <!-- / 3col text blocks -->

                          <!-- 2col text blocks -->
                    <div class="row space-bottom-2x">
                        <div class="col-sm-6">
                            <p><strong>One Half.</strong> Phasellus lobortis elit sed cursus ornare. Phasellus ut elit at nisl fringilla commodo nec non neque. Aliquam sed sagittis lorem, nec tempus lectus. Duis quis sollicitudin magna. Suspendisse sit amet orci venenatis, tempus leo eu, facilisis diam. Fusce vitae elit lobortis, efficitur purus nec, luctus ex. Phasellus volutpat ligula.</p>
                        </div>
                        <div class="col-sm-6">
                            <p><strong>One Half.</strong> Phasellus lobortis elit sed cursus ornare. Phasellus ut elit at nisl fringilla commodo nec non neque. Aliquam sed sagittis lorem, nec tempus lectus. Duis quis sollicitudin magna. Suspendisse sit amet orci venenatis, tempus leo eu, facilisis diam. Fusce vitae elit lobortis, efficitur purus nec, luctus ex. Phasellus volutpat ligula.</p>
                        </div>
                    </div><!-- / row -->
                          <!-- / 2col text blocks -->

                          <!-- fullwidth text block -->
                    <div class="row space-bottom-2x">
                        <div class="col-sm-12">
                            <p><strong>Full Width.</strong> Phasellus lobortis elit sed cursus ornare. Phasellus ut elit at nisl fringilla commodo nec non neque. Aliquam sed sagittis lorem, nec tempus lectus. Duis quis sollicitudin magna. Suspendisse sit amet orci venenatis, tempus leo eu, facilisis diam. Fusce vitae elit lobortis, efficitur purus nec, luctus ex. Phasellus volutpat ligula et neque sollicitudin tincidunt. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. In varius magna nec sodales vehicula. Sed cursus lorem sit amet ligula semper mollis. Ut feugiat eget diam vel egestas. Phasellus sem neque, convallis eget nibh et, vulputate aliquam enim. Morbi interdum ante et metus semper placerat.</p>
                        </div>
                    </div><!-- / row -->
                          <!-- / fullwidth text block -->



            </div>
        </div>
    </div>


    <div id="Buttons">
        <div class="bg-light lter b-b wrapper-md">
            <h1 class="m-n font-thin h3">Buttons</h1>
        </div>

        <div class="container">
            <div class="wrapper-md">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="m-t-xs">Button options</h4>
                        <div>
                            <button class="btn m-b-xs w-xs btn-default">Default</button>
                            <button class="btn m-b-xs w-xs btn-primary">Primary</button>
                            <button class="btn m-b-xs w-xs btn-success">Success</button>
                            <button class="btn m-b-xs w-xs btn-info">Info</button>
                            <button class="btn m-b-xs w-xs btn-warning">Warning</button>
                            <button class="btn m-b-xs w-xs btn-danger">Danger</button>
                            <button class="btn m-b-xs w-xs btn-dark">Dark</button>
                            <button class="btn m-b-xs w-xs btn-default disabled">Disabled</button>
                        </div>

                        <h4 class="m-t-lg">
                            Button addon
                        </h4>
                        <p>
                            <button class="btn m-b-xs btn-sm btn-primary btn-addon"><i class="fa fa-plus"></i>Primary</button>
                            <button class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-trash-o"></i>Info</button>
                            <button class="btn m-b-xs btn-sm btn-success btn-addon"><i class="fa fa-minus pull-right"></i>Success</button>
                            <button class="btn m-b-xs btn-sm btn-warning btn-addon"><i class="fa fa-circle"></i>Warning</button>
                            <button class="btn m-b-xs btn-sm btn-default btn-addon"><i class="fa fa-plus"></i>Default</button>
                        </p>
                        <p>
                            <button class="btn btn-default btn-addon"><i class="fa fa-music"></i>Default</button>
                            <button class="btn btn-info btn-addon"><i class="fa fa-play"></i>Info</button>
                        </p>

                        <h4 class="m-t">Button size</h4>
                        <p>
                            <button class="btn btn-default btn-lg">Large</button>
                            <button class="btn btn-primary btn-addon btn-lg"><i class="fa fa-plus"></i>Addon</button>
                        </p>
                        <p>
                            <button class="btn btn-default">Default button</button>
                        </p>
                        <p>
                            <button class="btn btn-default btn-sm">Small button</button>
                        </p>
                        <p>
                            <button class="btn btn-default btn-xs">Extra small button</button>
                        </p>

                        <h4 class="m-t-lg">Button dropdowns</h4>
                        <p class="text-muted">Single button dropdowns</p>
                        <div class="m-b-sm">
                            <div class="btn-group dropdown">
                                <button class="btn btn-default" data-toggle="dropdown">Action <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li><a href="">Action</a></li>
                                    <li><a href="">Another action</a></li>
                                    <li><a href="">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li><a href="">Separated link</a></li>
                                </ul>
                            </div>
                            <div class="btn-group dropdown">
                                <button class="btn btn-success" data-toggle="dropdown">Action <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li><a href="">Action</a></li>
                                    <li><a href="">Another action</a></li>
                                    <li><a href="">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li><a href="">Separated link</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="m-b-sm">
                            <div class="btn-group dropdown">
                                <button class="btn btn-default btn-sm" data-toggle="dropdown">Action <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li><a href="">Action</a></li>
                                    <li><a href="">Another action</a></li>
                                    <li><a href="">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li><a href="">Separated link</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="m-b-sm">
                            <div class="btn-group dropdown">
                                <button class="btn btn-default btn-xs" data-toggle="dropdown">Action <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li><a href="">Action</a></li>
                                    <li><a href="">Another action</a></li>
                                    <li><a href="">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li><a href="">Separated link</a></li>
                                </ul>
                            </div>
                        </div>
                        <p class="text-muted">Split button dropdowns &amp; variation </p>
                        <div class="m-b-sm">
                            <div class="btn-group dropdown">
                                <button class="btn btn-default">Action</button>
                                <button class="btn btn-default" data-toggle="dropdown"><span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li><a href="">Action</a></li>
                                    <li><a href="">Another action</a></li>
                                    <li><a href="">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li><a href="">Separated link</a></li>
                                </ul>
                            </div>
                            <div class="btn-group dropdown dropup">
                                <button class="btn btn-default">Action</button>
                                <button class="btn btn-default" data-toggle="dropdown"><span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li><a href="">Action</a></li>
                                    <li><a href="">Another action</a></li>
                                    <li><a href="">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li><a href="">Separated link</a></li>
                                </ul>
                            </div>
                        </div>

                        <h4 class="m-t-lg">Button with icon</h4>
                        <p>
                            <button class="btn btn-default"><i class="fa fa-html5"></i> Html5</button>
                            <button class="btn btn-info"><i class="fa fa-css3"></i> CSS3</button>
                        </p>
                        <p>
                            <button class="btn btn-default btn-lg btn-block"><i class="fa fa-bars pull-right"></i> Block button with icon</button>
                        </p>
                        <p>
                            <button class="btn btn-default btn-block"><i class="fa fa-bars pull-left"></i> Block button with icon</button>
                        </p>
                        <h4 class="m-t-lg">
                            Button icon
                        </h4>
                        <p>
                            <button class="btn btn-sm btn-icon btn-info"><i class="fa fa-twitter"></i></button>
                            <button class="btn btn-sm btn-icon btn-danger"><i class="fa fa-google-plus"></i></button>
                        </p>
                        <h4 class="m-t-lg">
                            Button icon rounded
                        </h4>
                        <p>
                            <button class="btn btn-rounded btn-sm btn-icon btn-default"><i class="fa fa-twitter"></i></button>
                            <button class="btn btn-rounded btn btn-icon btn-default"><i class="fa fa-facebook"></i></button>
                            <button class="btn btn-rounded btn-lg btn-icon btn-default"><i class="fa fa-google-plus"></i></button>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h4 class="m-t-xs">Rounded button</h4>
                        <div>
                            <button class="btn m-b-xs w-xs btn-default btn-rounded">Default</button>
                            <button class="btn m-b-xs w-xs btn-primary btn-rounded">Primary</button>
                            <button class="btn m-b-xs w-xs btn-success btn-rounded">Success</button>
                            <button class="btn m-b-xs w-xs btn-info btn-rounded">Info</button>
                            <button class="btn m-b-xs w-xs btn-warning btn-rounded">Warning</button>
                            <button class="btn m-b-xs w-xs btn-danger btn-rounded">Danger</button>
                            <button class="btn m-b-xs w-xs btn-dark btn-rounded">Dark</button>
                            <button class="btn m-b-xs w-xs btn-default btn-rounded disabled">Disabled</button>
                        </div>

                        <h4 class="m-t-lg">Button groups</h4>
                        <div class="m-b-sm">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default">Left</button>
                                <button type="button" class="btn btn-default">Middle</button>
                                <button type="button" class="btn btn-default">Right</button>
                            </div>
                        </div>
                        <p class="text-muted">Vertical button groups</p>
                        <div class="btn-group-vertical m-b-sm">
                            <button type="button" class="btn btn-default">Top</button>
                            <button type="button" class="btn btn-default">Middle</button>
                            <button type="button" class="btn btn-default">Bottom</button>
                        </div>
                        <p class="text-muted">Nested button groups</p>
                        <div class="btn-group m-b-sm">
                            <button type="button" class="btn btn-default">1</button>
                            <button type="button" class="btn btn-success">2</button>
                            <button type="button" class="btn btn-default">3</button>
                            <div class="btn-group dropdown">
                                <button type="button" class="btn btn-default" data-toggle="dropdown">
                                    Dropdown
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="">Dropdown link</a></li>
                                    <li><a href="">Dropdown link</a></li>
                                    <li><a href="">Dropdown link</a></li>
                                </ul>
                            </div>
                        </div>
                        <p class="text-muted">Justified button groups</p>
                        <div class="m-b-sm">
                            <div class="btn-group btn-group-justified">
                                <a href="" class="btn btn-primary">Left</a>
                                <a href="" class="btn btn-info">Middle</a>
                                <a href="" class="btn btn-success">Right</a>
                            </div>
                        </div>
                        <p class="text-muted">Multiple button groups</p>
                        <div class="btn-toolbar">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default">1</button>
                                <button type="button" class="btn btn-default active">2</button>
                                <button type="button" class="btn btn-default">3</button>
                                <button type="button" class="btn btn-default">4</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default">5</button>
                                <button type="button" class="btn btn-default">6</button>
                                <button type="button" class="btn btn-default">7</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default">8</button>
                            </div>
                        </div>

                        <h4 class="m-t-lg">Button components</h4>
                        <p class="text-muted">
                            <span>There are a few easy ways to quickly get started with Bootstrap, each one ...</span>
                            <span class="text-muted hide" id="moreless"> appealing to a different skill level and use case. Read through to see what suits your particular needs.</span>
                        </p>
                        <p>
                            <button class="btn btn-sm btn-default" ui-toggle-class="show" target="#moreless">
                                <i class="fa fa-plus text"></i>
                                <span class="text">More</span>
                                <i class="fa fa-minus text-active"></i>
                                <span class="text-active">Less</span>
                            </button>
                        </p>
                        <p>
                            <button class="btn btn-default" ui-toggle-class="btn-success">
                                <i class="fa fa-cloud-upload text"></i>
                                <span class="text">Upload</span>
                                <i class="fa fa-check text-active"></i>
                                <span class="text-active">Success</span>
                            </button>
                            <a class="btn btn-default" ui-toggle-class="button">
                                <i class="fa fa-heart-o text"></i>
                                <i class="fa fa-heart text-active text-danger"></i>
                            </a>
                            <a class="btn btn-default" ui-toggle-class="button">
          <span class="text">
            <i class="fa fa-thumbs-up text-success"></i> 25
          </span>
                                <span class="text-active">
            <i class="fa fa-thumbs-down text-danger"></i> 10
          </span>
                            </a>
                            <button class="btn btn-success" ui-toggle-class="show inline" target="#spin">
                                <span class="text">Save</span>
                                <span class="text-active">Saving...</span>
                            </button>
                            <i class="fa fa-spin fa-spinner hide" id="spin"></i>
                        </p>
                        <div class="m-b-sm">
                            <div class="btn-group" ng-init="radioModel = 'Male'">
                                <label class="btn btn-sm btn-info" ng-model="radioModel" btn-radio="'Male'"><i class="fa fa-check text-active"></i> Male</label>
                                <label class="btn btn-sm btn-success" ng-model="radioModel" btn-radio="'Female'"><i class="fa fa-check text-active"></i> Female</label>
                                <label class="btn btn-sm btn-primary" ng-model="radioModel" btn-radio="'N/A'"><i class="fa fa-check text-active"></i> N/A</label>
                            </div>
                        </div>

                        <div class="m-b-sm">
                            <div class="btn-group" ng-init="checkModel = {option1: true, option2: false}">
                                <label class="btn btn-sm btn-default" ng-model="checkModel.option1" btn-checkbox="">Option1</label>
                                <label class="btn btn-sm btn-default" ng-model="checkModel.option3" btn-checkbox="">Option2</label>
                            </div>
                        </div>

                        <h4 class="m-t-lg">
                            <button class="pull-right text-sm btn btn-xs btn-default" ui-toggle-class="btn-rounded" target="#social-buttons button">Toggle</button>
                            Social buttons
                        </h4>
                        <p id="social-buttons">
                            <button class="btn btn-rounded btn-sm btn-info"><i class="fa fa-fw fa-twitter"></i> Twitter</button>
                            <button class="btn btn-rounded btn-sm btn-danger"><i class="fa fa-fw fa-google-plus"></i> Google+</button>
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>



    <div id="Grid-System">
        <div class="bg-light lter b-b wrapper-md">
            <h1 class="m-n font-thin h3">Grid System</h1>
        </div>

        <div class="container text-center">
            <div class="wrapper-md">
                <div class="row">
                    <div class="col-lg-12">
                        <p>Base on Bootstrap grid system, you can get the columns as you want. 12 / (cols) = col-lg-(each-col-width-taken), like 12/3 = col-lg-4, 12/5 = col-lg-2.4 <span class="text-muted">(replace the '.' with '-')</span></p>
                    </div>
                    <div class="col-lg-12">
                        <div class="wrapper b bg-white">
                            <div class="panel-body">col-lg-12</div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="wrapper b bg-white">
                            <div class="panel-body">col-lg-6</div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="wrapper b bg-white">
                            <div class="panel-body">col-lg-6</div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="wrapper b bg-white">
                            <div class="panel-body">col-lg-4</div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="wrapper b bg-white">
                            <div class="panel-body">col-lg-4</div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="wrapper b bg-white">
                            <div class="panel-body">col-lg-4</div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="wrapper b bg-white">
                            <div class="panel-body">col-lg-3</div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="wrapper b bg-white">
                            <div class="panel-body">col-lg-3</div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="wrapper b bg-white">
                            <div class="panel-body">col-lg-3</div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="wrapper b bg-white">
                            <div class="panel-body">col-lg-3</div>
                        </div>
                    </div>
                    <div class="col-lg-2-4">
                        <div class="wrapper b bg-white">
                            <div class="panel-body">col-lg-2-4</div>
                        </div>
                    </div>
                    <div class="col-lg-2-4">
                        <div class="wrapper b bg-white">
                            <div class="panel-body">col-lg-2-4</div>
                        </div>
                    </div>
                    <div class="col-lg-2-4">
                        <div class="wrapper b bg-white">
                            <div class="panel-body">col-lg-2-4</div>
                        </div>
                    </div>
                    <div class="col-lg-2-4">
                        <div class="wrapper b bg-white">
                            <div class="panel-body">col-lg-2-4</div>
                        </div>
                    </div>
                    <div class="col-lg-2-4">
                        <div class="wrapper b bg-white">
                            <div class="panel-body">col-lg-2-4</div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="wrapper b bg-white">
                            <div class="panel-body">col-lg-2</div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="wrapper b bg-white">
                            <div class="panel-body">col-lg-2</div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="wrapper b bg-white">
                            <div class="panel-body">col-lg-2</div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="wrapper b bg-white">
                            <div class="panel-body">col-lg-2</div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="wrapper b bg-white">
                            <div class="panel-body">col-lg-2</div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="wrapper b bg-white">
                            <div class="panel-body">col-lg-2</div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <p>Mobile, tablet, and desktop</p>
                    </div>
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="wrapper b bg-white">
                                    <div class="panel-body">col-xs-6</div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="wrapper b bg-white">
                                    <div class="panel-body">col-xs-6</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="wrapper b bg-white">
                            <div class="panel-body">col-lg-8</div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="wrapper b bg-white">
                                    <div class="panel-body">col-sm-6</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="wrapper b bg-white">
                                    <div class="panel-body">col-sm-6</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="wrapper b bg-white">
                            <div class="panel-body">col-lg-6</div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="wrapper b bg-white">
                                    <div class="panel-body">col-md-6</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="wrapper b bg-white">
                                    <div class="panel-body">col-md-6</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="wrapper b bg-white">
                            <div class="panel-body">col-lg-4</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="wrapper b bg-white">
                            <div class="panel-body">col-sm-6</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="wrapper b bg-white">
                            <div class="panel-body">col-sm-6</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div id="Form-Elements">
        <div class="bg-light lter b-b wrapper-md">
            <h1 class="m-n font-thin h3">Form Elements</h1>
        </div>

        <div class="container text-center">
            <div class="wrapper-md">
                <div class="form-horizontal" method="get">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Rounded</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control rounded">
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">With help</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control">
                            <span class="help-block m-b-none">A block of help text that breaks onto a new line and may extend beyond one line.</span>
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-id-1">Label focus</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="input-id-1">
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" class="form-control">
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Placeholder</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="placeholder">
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Disabled</label>
                        <div class="col-lg-10">
                            <input class="form-control" type="text" placeholder="Disabled input here..." disabled="">
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Static control</label>
                        <div class="col-lg-10">
                            <p class="form-control-static">email@example.com</p>
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Checkboxes and radios</label>
                        <div class="col-sm-10">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="">
                                    Option one is this and that—be sure to include why it's great
                                </label>
                            </div>

                            <div class="radio">
                                <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                                    Option one is this and that—be sure to include why it's great
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                                    Option two can be something else and selecting it will deselect option one
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Inline checkboxes</label>
                        <div class="col-sm-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" value="option1"> a
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" value="option2"> b
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" value="option3"> c
                            </label>
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">CSS3 Checkboxes &amp; radios</label>
                        <div class="col-sm-10">
                            <div class="checkbox">
                                <label class="i-checks">
                                    <input type="checkbox" value="">
                                    <i></i>
                                    Option one
                                </label>
                            </div>
                            <div class="checkbox">
                                <label class="i-checks">
                                    <input type="checkbox" checked="" value="">
                                    <i></i>
                                    Option two checked
                                </label>
                            </div>
                            <div class="checkbox">
                                <label class="i-checks">
                                    <input type="checkbox" checked="" disabled="" value="">
                                    <i></i>
                                    Option three checked and disabled
                                </label>
                            </div>
                            <div class="checkbox">
                                <label class="i-checks">
                                    <input type="checkbox" disabled="" value="">
                                    <i></i>
                                    Option four disabled
                                </label>
                            </div>
                            <div class="radio">
                                <label class="i-checks">
                                    <input type="radio" name="a" value="option1">
                                    <i></i>
                                    Option one
                                </label>
                            </div>
                            <div class="radio">
                                <label class="i-checks">
                                    <input type="radio" name="a" value="option2" checked="">
                                    <i></i>
                                    Option two checked
                                </label>
                            </div>
                            <div class="radio">
                                <label class="i-checks">
                                    <input type="radio" value="option2" checked="" disabled="">
                                    <i></i>
                                    Option three checked and disabled
                                </label>
                            </div>
                            <div class="radio">
                                <label class="i-checks">
                                    <input type="radio" name="a" disabled="">
                                    <i></i>
                                    Option four disabled
                                </label>
                            </div>

                            <div class="radio">
                                <label class="i-checks i-checks-sm">
                                    <input type="radio" name="a">
                                    <i></i>
                                    Small size radio
                                </label>
                            </div>
                            <div class="checkbox">
                                <label class="i-checks i-checks-sm">
                                    <input type="checkbox">
                                    <i></i>
                                    Small size checkbox
                                </label>
                            </div>
                            <div class="m-b-xs m-t">
                                <label class="i-checks i-checks-lg">
                                    <input type="radio" name="a">
                                    <i></i>
                                    Large size radio
                                </label>
                            </div>
                            <div class="checkbox">
                                <label class="i-checks i-checks-lg">
                                    <input type="checkbox">
                                    <i></i>
                                    Large size checkbox
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Inline checkboxes</label>
                        <div class="col-sm-10">
                            <label class="checkbox-inline i-checks">
                                <input type="checkbox" value="option1"><i></i> a
                            </label>
                            <label class="checkbox-inline i-checks">
                                <input type="checkbox" value="option2"><i></i> b
                            </label>
                            <label class="checkbox-inline i-checks">
                                <input type="checkbox" value="option3"><i></i> c
                            </label>
                        </div>
                    </div>

                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Switch</label>
                        <div class="col-sm-10">
                            <label class="i-switch m-t-xs m-r">
                                <input type="checkbox" checked="">
                                <i></i>
                            </label>
                            <label class="i-switch bg-info m-t-xs m-r">
                                <input type="checkbox" checked="">
                                <i></i>
                            </label>
                            <label class="i-switch bg-primary m-t-xs m-r">
                                <input type="checkbox" checked="">
                                <i></i>
                            </label>
                            <label class="i-switch bg-danger m-t-xs m-r">
                                <input type="checkbox" checked="">
                                <i></i>
                            </label>
                        </div>
                    </div>

                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Radio Switch</label>
                        <div class="col-sm-10">
                            <label class="i-switch bg-primary m-t-xs m-r">
                                <input type="radio" name="switch" checked="">
                                <i></i>
                            </label>
                            <label class="i-switch bg-warning m-t-xs m-r">
                                <input type="radio" name="switch">
                                <i></i>
                            </label>
                        </div>
                    </div>

                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Switch size</label>
                        <div class="col-sm-10">
                            <label class="i-switch i-switch-md bg-info m-t-xs m-r">
                                <input type="checkbox" checked="">
                                <i></i>
                            </label>
                            <label class="i-switch i-switch-lg bg-dark m-t-xs m-r">
                                <input type="checkbox">
                                <i></i>
                            </label>
                        </div>
                    </div>

                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Select</label>
                        <div class="col-sm-10">
                            <select name="account" class="form-control m-b">
                                <option>option 1</option>
                                <option>option 2</option>
                                <option>option 3</option>
                                <option>option 4</option>
                            </select>
                            <div class="col-lg-4 m-l-n">
                                <select multiple="" class="form-control">
                                    <option>option 1</option>
                                    <option>option 2</option>
                                    <option>option 3</option>
                                    <option>option 4</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group has-success">
                        <label class="col-sm-2 control-label">Input with success</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group has-warning">
                        <label class="col-sm-2 control-label">Input with warning</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group has-error">
                        <label class="col-sm-2 control-label">Input with error</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Control sizing</label>
                        <div class="col-sm-10">
                            <input class="form-control input-lg m-b" type="text" placeholder=".input-lg">
                            <input class="form-control m-b" type="text" placeholder="Default input">
                            <input class="form-control input-sm" type="text" placeholder=".input-sm">
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Column sizing</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-md-2">
                                    <input type="text" class="form-control" placeholder=".col-md-2">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" placeholder=".col-md-3">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder=".col-md-4">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Input groups</label>
                        <div class="col-sm-10">
                            <div class="input-group m-b">
                                <span class="input-group-addon">@</span>
                                <input type="text" class="form-control" placeholder="Username">
                            </div>
                            <div class="input-group m-b">
                                <input type="text" class="form-control">
                                <span class="input-group-addon">.00</span>
                            </div>
                            <div class="input-group m-b">
                                <span class="input-group-addon">$</span>
                                <input type="text" class="form-control">
                                <span class="input-group-addon">.00</span>
                            </div>
                            <div class="input-group m-b">
              <span class="input-group-addon">
                <input type="checkbox">
              </span>
                                <input type="text" class="form-control">
                            </div>
                            <div class="input-group">
              <span class="input-group-addon">
                <input type="radio">
              </span>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Button addons</label>
                        <div class="col-sm-10">
                            <div class="input-group m-b">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Go!</button>
              </span>
                                <input type="text" class="form-control">
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control">
                                <span class="input-group-btn">
                <button class="btn btn-default" type="button">Go!</button>
              </span>
                            </div>
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">With dropdowns</label>
                        <div class="col-sm-10">
                            <div class="input-group m-b">
                                <div class="input-group-btn dropdown" dropdown="">
                                    <button type="button" class="btn btn-default" dropdown-toggle="">Action <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="">Action</a></li>
                                        <li><a href="">Another action</a></li>
                                        <li><a href="">Something else here</a></li>
                                        <li class="divider"></li>
                                        <li><a href="">Separated link</a></li>
                                    </ul>
                                </div><!-- /btn-group -->
                                <input type="text" class="form-control">
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control">
                                <div class="input-group-btn dropdown" dropdown="">
                                    <button type="button" class="btn btn-default" dropdown-toggle="">Action <span class="caret"></span></button>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="">Action</a></li>
                                        <li><a href="">Another action</a></li>
                                        <li><a href="">Something else here</a></li>
                                        <li class="divider"></li>
                                        <li><a href="">Separated link</a></li>
                                    </ul>
                                </div><!-- /btn-group -->
                            </div>
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Segmented</label>
                        <div class="col-sm-10">
                            <div class="input-group m-b">
                                <div class="input-group-btn dropdown" dropdown="">
                                    <button type="button" class="btn btn-default" tabindex="-1">Action</button>
                                    <button type="button" class="btn btn-default" dropdown-toggle=""><span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="">Action</a></li>
                                        <li><a href="">Another action</a></li>
                                        <li><a href="">Something else here</a></li>
                                        <li class="divider"></li>
                                        <li><a href="">Separated link</a></li>
                                    </ul>
                                </div><!-- /btn-group -->
                                <input type="text" class="form-control">
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control">
                                <div class="input-group-btn dropdown" dropdown="">
                                    <button type="button" class="btn btn-default" tabindex="-1">Action</button>
                                    <button type="button" class="btn btn-default" dropdown-toggle=""><span class="caret"></span></button>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="">Action</a></li>
                                        <li><a href="">Another action</a></li>
                                        <li><a href="">Something else here</a></li>
                                        <li class="divider"></li>
                                        <li><a href="">Separated link</a></li>
                                    </ul>
                                </div><!-- /btn-group -->
                            </div>
                        </div>
                    </div>


                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Button radio</label>
                        <div class="col-sm-10">
                            <div class="btn-group m-r" ng-controller="ButtonsDemoCtrl">
                                <label class="btn btn-default" ng-model="radioModel" btn-radio="'Left'" uncheckable="">Left</label>
                                <label class="btn btn-default" ng-model="radioModel" btn-radio="'Middle'" uncheckable="">Middle</label>
                                <label class="btn btn-default" ng-model="radioModel" btn-radio="'Right'" uncheckable="">Right</label>
                            </div>
                        </div>
                    </div>

                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Button checkbox</label>
                        <div class="col-sm-10">
                            <div class="btn-group">
                                <label class="btn btn-default" ng-model="checkModel.left" btn-checkbox="">Left</label>
                                <label class="btn btn-default" ng-model="checkModel.middle" btn-checkbox="">Middle</label>
                                <label class="btn btn-default" ng-model="checkModel.right" btn-checkbox="">Right</label>
                            </div>
                        </div>
                    </div>

                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Slider</label>
                        <div class="col-sm-10">
                            <div class="slider slider-horizontal" style="width: 210px;"><div class="slider-track"><div class="slider-selection" style="left: 0%; width: 25%;"></div><div class="slider-handle round" style="left: 25%;"></div><div class="slider-handle round hide" style="left: 0%;"></div></div><div class="tooltip top" style="top: -30px; left: 41px;"><div class="tooltip-arrow"></div><div class="tooltip-inner">5</div></div><input id="slider" ui-jq="slider" ui-options="{
              min: 0,
              max: 20,
              step: 1,
              value: 5
            }" class="slider slider-horizontal form-control" type="text" style="display: none;"></div> 5
                        </div>
                    </div>

                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Vertical slider</label>
                        <div class="col-sm-10">
                            <div class="slider slider-vertical"><div class="slider-track"><div class="slider-selection" style="top: 0%; height: 40%;"></div><div class="slider-handle round" style="top: 40%;"></div><div class="slider-handle round hide" style="top: 0%;"></div></div><div class="tooltip right" style="left: 100%; top: 73px;"><div class="tooltip-arrow"></div><div class="tooltip-inner">11</div></div><input ui-jq="slider" class="slider slider-vertical form-control" type="text" value="" data-slider-min="5" data-slider-max="20" data-slider-step="1" data-slider-value="11" data-slider-orientation="vertical" style="display: none;"></div>
                            <div class="slider slider-vertical"><div class="slider-track"><div class="slider-selection" style="top: 0%; height: 66.6667%;"></div><div class="slider-handle round" style="top: 66.6667%;"></div><div class="slider-handle round hide" style="top: 0%;"></div></div><div class="tooltip right" style="left: 100%; top: 129px;"><div class="tooltip-arrow"></div><div class="tooltip-inner">15</div></div><input ui-jq="slider" class="slider slider-vertical form-control" type="text" value="" data-slider-min="5" data-slider-max="20" data-slider-step="1" data-slider-value="15" data-slider-orientation="vertical" style="display: none;"></div>
                            <div class="slider slider-vertical"><div class="slider-track"><div class="slider-selection" style="top: 0%; height: 46.6667%;"></div><div class="slider-handle round" style="top: 46.6667%;"></div><div class="slider-handle round hide" style="top: 0%;"></div></div><div class="tooltip right" style="left: 100%; top: 87px;"><div class="tooltip-arrow"></div><div class="tooltip-inner">12</div></div><input ui-jq="slider" class="slider slider-vertical form-control" type="text" value="" data-slider-min="5" data-slider-max="20" data-slider-step="1" data-slider-value="12" data-slider-orientation="vertical" style="display: none;"></div>
                        </div>
                    </div>

                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Range selector</label>
                        <div class="col-sm-10">
                            <div class="slider slider-horizontal" style="width: 210px;"><div class="slider-track"><div class="slider-selection" style="left: 15.6566%; width: 61.1111%;"></div><div class="slider-handle round" style="left: 15.6566%;"></div><div class="slider-handle round" style="left: 76.7677%;"></div></div><div class="tooltip top" style="top: -30px; left: 64.0455px;"><div class="tooltip-arrow"></div><div class="tooltip-inner">165 : 770</div></div><input type="text" ui-jq="slider" class="slider form-control" value="" data-slider-min="10" data-slider-max="1000" data-slider-step="5" data-slider-value="[250,750]" style="display: none;"></div>
                        </div>
                    </div>

                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Spinner</label>
                        <div class="col-sm-10">
                            <div class="m-b">
                                <div class="input-group bootstrap-touchspin"><span class="input-group-btn"><button class="btn btn-default bootstrap-touchspin-down" type="button">-</button></span><span class="input-group-addon bootstrap-touchspin-prefix">$</span><input ui-jq="TouchSpin" type="text" value="0" class="form-control" data-min="0" data-max="10" data-step="0.1" data-decimals="2" data-prefix="$" style="display: block;"><span class="input-group-addon bootstrap-touchspin-postfix" style="display: none;"></span><span class="input-group-btn"><button class="btn btn-default bootstrap-touchspin-up" type="button">+</button></span></div>
                            </div>
                            <div class="m-b">
                                <div class="input-group bootstrap-touchspin"><span class="input-group-btn"><button class="btn btn-default bootstrap-touchspin-down" type="button">-</button></span><span class="input-group-addon bootstrap-touchspin-prefix" style="display: none;"></span><input ui-jq="TouchSpin" type="text" value="5" class="form-control" data-min="0" data-max="10" data-step="0.1" data-decimals="2" data-postfix="%" style="display: block;"><span class="input-group-addon bootstrap-touchspin-postfix">%</span><span class="input-group-btn"><button class="btn btn-default bootstrap-touchspin-up" type="button">+</button></span></div>
                            </div>
                            <div>
                                <div class="input-group bootstrap-touchspin"><span class="input-group-addon bootstrap-touchspin-prefix" style="display: none;"></span><input ui-jq="TouchSpin" type="text" value="10" class="form-control" data-min="0" data-max="20" data-verticalbuttons="true" data-verticalupclass="fa fa-caret-up" data-verticaldownclass="fa fa-caret-down" style="display: block;"><span class="input-group-addon bootstrap-touchspin-postfix" style="display: none;"></span><span class="input-group-btn-vertical"><button class="btn btn-default bootstrap-touchspin-up" type="button"><i class="fa fa-caret-up"></i></button><button class="btn btn-default bootstrap-touchspin-down" type="button"><i class="fa fa-caret-down"></i></button></span></div>
                            </div>
                        </div>
                    </div>

                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Chosen</label>
                        <div class="col-sm-10">
                            <select ui-jq="chosen" class="w-full" style="display: none;">
                                <optgroup label="Alaskan/Hawaiian Time Zone">
                                    <option value="AK">Alaska</option>
                                    <option value="HI">Hawaii</option>
                                </optgroup>
                                <optgroup label="Pacific Time Zone">
                                    <option value="CA">California</option>
                                    <option value="NV">Nevada</option>
                                    <option value="OR">Oregon</option>
                                    <option value="WA">Washington</option>
                                </optgroup>
                                <optgroup label="Mountain Time Zone">
                                    <option value="AZ">Arizona</option>
                                    <option value="CO">Colorado</option>
                                    <option value="ID">Idaho</option>
                                    <option value="MT">Montana</option><option value="NE">Nebraska</option>
                                    <option value="NM">New Mexico</option>
                                    <option value="ND">North Dakota</option>
                                    <option value="UT">Utah</option>
                                    <option value="WY">Wyoming</option>
                                </optgroup>
                                <optgroup label="Central Time Zone">
                                    <option value="AL">Alabama</option>
                                    <option value="AR">Arkansas</option>
                                    <option value="IL">Illinois</option>
                                    <option value="IA">Iowa</option>
                                    <option value="KS">Kansas</option>
                                    <option value="KY">Kentucky</option>
                                    <option value="LA">Louisiana</option>
                                    <option value="MN">Minnesota</option>
                                    <option value="MS">Mississippi</option>
                                    <option value="MO">Missouri</option>
                                    <option value="OK">Oklahoma</option>
                                    <option value="SD">South Dakota</option>
                                    <option value="TX">Texas</option>
                                    <option value="TN">Tennessee</option>
                                    <option value="WI">Wisconsin</option>
                                </optgroup>
                                <optgroup label="Eastern Time Zone">
                                    <option value="CT">Connecticut</option>
                                    <option value="DE">Delaware</option>
                                    <option value="FL">Florida</option>
                                    <option value="GA">Georgia</option>
                                    <option value="IN">Indiana</option>
                                    <option value="ME">Maine</option>
                                    <option value="MD">Maryland</option>
                                    <option value="MA">Massachusetts</option>
                                    <option value="MI">Michigan</option>
                                    <option value="NH">New Hampshire</option><option value="NJ">New Jersey</option>
                                    <option value="NY">New York</option>
                                    <option value="NC">North Carolina</option>
                                    <option value="OH">Ohio</option>
                                    <option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option>
                                    <option value="VT">Vermont</option><option value="VA">Virginia</option>
                                    <option value="WV">West Virginia</option>
                                </optgroup>
                            </select><div class="chosen-container chosen-container-single" style="width: 1356px;" title=""><a class="chosen-single" tabindex="-1"><span>Alaska</span><div><b></b></div></a><div class="chosen-drop"><div class="chosen-search"><input type="text" autocomplete="off"></div><ul class="chosen-results"></ul></div></div>
                        </div>
                    </div>

                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Chosen multiple</label>
                        <div class="col-sm-10">
                            <select ui-jq="chosen" multiple="" class="w-md" style="display: none;">
                                <option value="AK">Alaska</option>
                                <option value="HI">Hawaii</option>
                                <option value="CA">California</option>
                                <option value="NV">Nevada</option>
                                <option value="OR">Oregon</option>
                                <option value="WA">Washington</option>
                            </select><div class="chosen-container chosen-container-multi" style="width: 240px;" title=""><ul class="chosen-choices"><li class="search-field"><input type="text" value="Select Some Options" class="default" autocomplete="off" style="width: 147px;"></li></ul><div class="chosen-drop"><ul class="chosen-results"></ul></div></div>
                        </div>
                    </div>

                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Tags input</label>
                        <div class="col-sm-10">
                            <input ui-jq="tagsinput" ui-options="" class="form-control w-md" style="display: none;"><div class="bootstrap-tagsinput"><input type="text" placeholder="" style="width: 3em !important;"></div>
                        </div>
                    </div>

                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Datepicker</label>
                        <div class="col-sm-10" ng-controller="DatepickerDemoCtrl">
                            <div class="input-group w-md">
                                <input type="text" class="form-control" datepicker-popup="" ng-model="dt" is-open="opened" datepicker-options="dateOptions" ng-required="true" close-text="Close">
                                <span class="input-group-btn">
                <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
              </span>
                            </div>
                        </div>
                    </div>

                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Date range picker</label>
                        <div class="col-sm-10">
                            <input ui-jq="daterangepicker" ui-options="{
                format: 'YYYY-MM-DD',
                startDate: '2013-01-01',
                endDate: '2013-12-31'
              }" class="form-control w-md">
                        </div>
                    </div>

                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">File input</label>
                        <div class="col-sm-10">
                            <input ui-jq="filestyle" type="file" data-icon="false" data-classbutton="btn btn-default" data-classinput="form-control inline v-middle input-s" id="filestyle-0" tabindex="-1" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);"><div class="bootstrap-filestyle input-group"><input type="text" class="form-control " disabled=""> <span class="group-span-filestyle input-group-btn" tabindex="0"><label for="filestyle-0" class="btn btn-default "><span class="glyphicon glyphicon-folder-open"></span> Choose file</label></span></div>
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Wysiwyg</label>
                        <div class="col-sm-10">
                            <div class="btn-toolbar m-b-sm btn-editor" data-role="editor-toolbar" data-target="#editor">
                                <div class="btn-group dropdown" dropdown="">
                                    <a class="btn btn-default" dropdown-toggle="" tooltip="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="" data-edit="fontName Serif" style="font-family:'Serif'">Serif</a></li>
                                        <li><a href="" data-edit="fontName Sans" style="font-family:'Sans'">Sans</a></li>
                                        <li><a href="" data-edit="fontName Arial" style="font-family:'Arial'">Arial</a></li></ul>
                                </div>
                                <div class="btn-group dropdown" dropdown="">
                                    <a class="btn btn-default" dropdown-toggle="" data-toggle="dropdown" tooltip="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="" data-edit="fontSize 5" style="font-size:24px">Huge</a></li>
                                        <li><a href="" data-edit="fontSize 3" style="font-size:18px">Normal</a></li>
                                        <li><a href="" data-edit="fontSize 1" style="font-size:14px">Small</a></li>
                                    </ul>
                                </div>
                                <div class="btn-group">
                                    <a class="btn btn-default" data-edit="bold" tooltip="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                                    <a class="btn btn-default" data-edit="italic" tooltip="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
                                    <a class="btn btn-default" data-edit="strikethrough" tooltip="Strikethrough"><i class="fa fa-strikethrough"></i></a>
                                    <a class="btn btn-default" data-edit="underline" tooltip="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
                                </div>
                                <div class="btn-group">
                                    <a class="btn btn-default" data-edit="insertunorderedlist" tooltip="Bullet list"><i class="fa fa-list-ul"></i></a>
                                    <a class="btn btn-default" data-edit="insertorderedlist" tooltip="Number list"><i class="fa fa-list-ol"></i></a>
                                    <a class="btn btn-default" data-edit="outdent" tooltip="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a>
                                    <a class="btn btn-default" data-edit="indent" tooltip="Indent (Tab)"><i class="fa fa-indent"></i></a>
                                </div>
                                <div class="btn-group">
                                    <a class="btn btn-default btn-info" data-edit="justifyleft" tooltip="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                                    <a class="btn btn-default" data-edit="justifycenter" tooltip="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                                    <a class="btn btn-default" data-edit="justifyright" tooltip="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
                                    <a class="btn btn-default" data-edit="justifyfull" tooltip="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
                                </div>
                                <div class="btn-group dropdown" dropdown="">
                                    <a class="btn btn-default" dropdown-toggle="" tooltip="Hyperlink"><i class="fa fa-link"></i></a>
                                    <div class="dropdown-menu">
                                        <div class="input-group m-l-xs m-r-xs">
                                            <input class="form-control input-sm" id="LinkInput" placeholder="URL" type="text" data-edit="createLink">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-default" type="button">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                    <a class="btn btn-default" data-edit="unlink" tooltip="Remove Hyperlink"><i class="fa fa-cut"></i></a>
                                </div>

                                <div class="btn-group">
                                    <a class="btn btn-default" tooltip="Insert picture (or just drag &amp; drop)" id="pictureBtn"><i class="fa fa-picture-o"></i></a>
                                    <input type="file" data-edit="insertImage" style="position:absolute; opacity:0; width:41px; height:34px">
                                </div>
                                <div class="btn-group">
                                    <a class="btn btn-default" data-edit="undo" tooltip="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
                                    <a class="btn btn-default" data-edit="redo" tooltip="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
                                </div>
                            </div>
                            <div ui-jq="wysiwyg" class="form-control" style="overflow:scroll;height:200px;max-height:200px" contenteditable="true">
                                Go ahead…
                            </div>
                        </div>
                    </div>

                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button type="submit" class="btn btn-default">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection