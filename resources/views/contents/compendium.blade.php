<div class="row">
    <div class="col-auto no-padder">
        <ul class="list-group list-group-flush">
            @foreach($list as $key => $value)
                <li class="list-group-item text-muted">{{ $key }}</li>
            @endforeach
        </ul>
    </div>

    <div class="col-auto no-padder">
        <ul class="list-group list-group-flush">
            @foreach($list as $key => $value)
                <li class="list-group-item">{{ $value }}</li>
            @endforeach
        </ul>
    </div>
</div>
