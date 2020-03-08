<div class="row padder-v">
    <div class="col">
        <p class="font-bold text-black mb-2">General</p>
        @foreach($list as $key => $value)
            <dl>
                <dt>{{ $key }}</dt>
                <dd>{{ $value }}</dd>
            </dl>
        @endforeach
    </div>
</div>
