<div class="row">
    <div class="col">
        @foreach($list as $key => $value)
            <dl>
                <dt>{{ $key }}</dt>
                <dd>{{ $value }}</dd>
            </dl>
        @endforeach
    </div>
</div>

