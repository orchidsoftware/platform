@if(isset($styles))
    <style>
        {{$styles}}
    </style>
@endif
@if(isset($div))
    <{{$div ?? 'div'}} @include('dashboard::partials.fields.attributes', ['attributes' => $attributes])>
@endif
@if(isset($text))
    {{$text}}
@endif
@if(isset($enddiv))
    </{{$enddiv ?? 'div'}}>
@endif
@if(isset($script))
    <script>
        {{$script}}
    </script>
@endif
@if(isset($hr))
    <div class="line line-dashed b-b line-lg"></div>
@endif