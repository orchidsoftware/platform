<div class="bg-white rounded shadow-sm mb-3 p-4">
    @empty(!$label)<p class="font-weight-bold text-black mb-2">{{ $label }}</p>@endempty
    @foreach($list as $key => $value)
        <dl>
            <dt>{{ $key }}</dt>
            <dd>{{ $value }}</dd>
        </dl>
    @endforeach
</div>
