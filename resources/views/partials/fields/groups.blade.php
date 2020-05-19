<div class="row align-items-center">
    @foreach($cols as $col)
        <div class="col-auto @if (!$loop->last) pr-0 @endif">
            {!! $col !!}
        </div>
    @endforeach
</div>
