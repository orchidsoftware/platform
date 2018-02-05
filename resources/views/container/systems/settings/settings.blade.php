@extends('dashboard::layouts.dashboard')


@section('title',$name)
@section('description',$description)


@section('navbar')

    <div class="text-right">
        <div class="btn-group" role="group" aria-label="...">
            <button type="submit" form="form-group" class="btn btn-link">
                <i class="sli icon-check fa-2x"></i>
            </button>
        </div>
    </div>
@stop


@section('content')

    <div class="nav-tabs-alt bg-white-only">
        <ul class="nav nav-tabs padder bg-light" role="tablist">
            @foreach($forms as $name => $form)

                <li class="nav-item">
                    <a class="nav-link @if ($loop->first) active @endif" data-target="#tab-{{str_slug($name)}}" role="tab" data-toggle="tab">
                        {!! $name !!}
                    </a>
                </li>
            @endforeach

        </ul>
    </div>
    <!-- main content  -->
    <section>
        <div class="bg-white-only bg-auto no-border-xs">
            <form class="form-horizontal" action="{{route('dashboard.systems.settings')}}" id="form-group"
                  method="post">
                <div class="tab-content">
                    @foreach($forms as $name => $form)

                        <div role="tabpanel"
                             class="tab-pane @if ($loop->first) active @endif"
                             id="tab-{{str_slug($name)}}">
                            {!! $form !!}
                        </div>
                    @endforeach

                </div>


                {{ csrf_field() }}


            </form>
        </div>
    </section>
    <!-- / main content  -->


@stop




