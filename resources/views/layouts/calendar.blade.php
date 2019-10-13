<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>


    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="{{ url('/home') }}">Home</a>
            @else
                <a href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
    @endif

    <div class="content">

        <div class="row">
            @foreach($dates as $nameMoth => $moth)

                <div class="col-md-4 p-0 ">
                    <div class="card border-0">
                        <div class="card-body">
                            <h6 class="card-title text-uppercase mb-1">{{ $nameMoth }}</h6>


                            <div class="table-responsive">
                            <table class="table table-sm">
                                <thead class="thead-dark">
                                <tr class="text-uppercase">
                                    @foreach($weeks as $week)
                                        <th>{{ $week }}</th>
                                    @endforeach
                                </tr>
                                </thead>

                                <tbody class="font-weight-normal" style="font-weight: 400">
                                @foreach($moth as $key => $week)


                                    <tr>
                                    @foreach($week as $key=> $day)

                                        @if ($loop->first)
                                                @php
                                                    $dayOfWeek = reset($week)->dayOfWeekIso;
                                                @endphp
                                            @for($i = 1; $i < $dayOfWeek; $i++)
                                                <th></th>
                                            @endfor

                                        @endif

                                        <th @if($day->startOfDay()->eq($current->startOfDay())) class="bg-dark text-white" @endif>
                                            {{$day->format('j')}}
                                        </th>
                                    @endforeach
                                    </tr>
                                @endforeach
                                </tbody>


                            </table>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>

        <p class="card-text">Some quick example text to build on the card title and make up the bulk
            of the card's content.</p>
        <a href="#" class="card-link">Card link</a>
        <a href="#" class="card-link">Another link</a>


    </div>
</div>
</body>
</html>
