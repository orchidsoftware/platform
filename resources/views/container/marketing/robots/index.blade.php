@extends('dashboard::layouts.dashboard')


@section('title',trans('dashboard::marketing/robots.title'))
@section('description',trans('dashboard::marketing/robots.description'))


@section('navbar')
    <div class="col-sm-6 col-xs-12 text-right">
        <div class="btn-group btn-group-sm" role="group" aria-label="...">
            <button type="submit" form="robots-form" class="btn btn-link"><i class="icon-check fa fa-2x"></i></button>
        </div>
    </div>
@stop

@section('content')


    <section class="wrapper" id="utm-generate">
        <div class="bg-white-only bg-auto no-border-xs">

            <div class="row">
                <div class="col-md-6">
                    <form id="robots-form" method="post" action="{{route('dashboard.marketing.robots.store')}}">
                        <div class="wrapper-lg">

                            <div class="form-group">
                                <textarea class="form-control no-resize" rows="30"
                                          name="content">{{$content or ''}}</textarea>
                            </div>

                        </div>
                        {{csrf_field()}}
                    </form>
                </div>


                <div class="col-md-6">
                    <div class="wrapper-lg">
                        <p>This example tells <b>all robots</b> that they <b>can visit all files</b> because the
                            wildcard
                            <code>*</code>
                            stands for all robots and the <code>Disallow</code> directive has no value, meaning no pages
                            are
                            disallowed.</p>
                        <pre>User-agent: *
Disallow:
</pre>

                        <p>The same result can be accomplished with an empty or missing robots.txt file.</p>
                        <p>This example tells <b>all robots</b> to stay out of a website:</p>
                        <pre>User-agent: *
Disallow: /
</pre>
                        <p>This example tells <b>all robots</b> not to enter three directories:</p>
                        <pre>User-agent: *
Disallow: /cgi-bin/
Disallow: /tmp/
Disallow: /junk/
</pre>
                        <p>This example tells <b>all robots</b> to stay away from one specific file:</p>
                        <pre>User-agent: *
Disallow: /directory/file.html
</pre>
                    </div>
                </div>
            </div>

        </div>
    </section>


@stop

