@if(isset($stylesheets))
    @push('stylesheets')
        {!!$stylesheets!!}
    @endpush
@endif    
@if(isset($styles))
    <style>
        {{$styles}}
    </style>
@endif
@if(isset($div))
    <{{$div ?? 'div'}} 
        @if(!isset($attr))@include('dashboard::partials.fields.attributes', ['attributes' => $attributes])@endif
        @if(isset($divattr))@include('dashboard::partials.fields.attributes', ['attributes' => collect($divattr)])@endif
    >
@endif

@if(isset($attr))
    @if ($withgroup ?? true)
        @component('dashboard::partials.fields.group',get_defined_vars())
    @endif
            <{{$attr ?? 'input'}} @include('dashboard::partials.fields.attributes', ['attributes' => $attributes])
            @if(isset($dataattr))@include('dashboard::partials.fields.attributes', ['attributes' => collect($dataattr)])@endif >
                {!! $value or '' !!}
            </{{$attr ?? 'input'}}>
    @if ($withgroup ?? true)
        @endcomponent
    @endif
@endif

@if(isset($text))
    {!!$text!!}
@endif
@if(isset($enddiv))
    </{{$enddiv ?? 'div'}}>
@endif

@if(isset($script))
    <script>
        {!!$script!!}
    </script>
@endif
@if(isset($hr))
    <div class="line line-dashed b-b line-lg"></div>
@endif
@if(isset($scripts))
    @push('scripts')
        {!!$scripts!!}
    @endpush
@endif    
