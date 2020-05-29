<div class="row align-items-center">
    @foreach($group as $field)
        <div class="{{ $class }} @if (!$loop->last) pr-0 @endif">
            {!! $field !!}
        </div>
    @endforeach
</div>
