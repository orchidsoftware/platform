<div class="row padder-v">
    <div class="col">
        @empty(!$label)<p class="font-bold text-black mb-2">{{ $label }}</p>@endempty
        @foreach($list as $key => $value)
            <dl>
                <dt>{{ $key }}</dt>
                <dd>{{ $value }}</dd>
            </dl>
        @endforeach
    </div>
</div>
