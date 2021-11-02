<div class="row form-group {{ $align }}">
    @foreach($group as $field)
        <div class="{{ $class }} @if (!$loop->last) pe-md-0 @endif">
            {!! $field !!}
        </div>
    @endforeach
</div>
