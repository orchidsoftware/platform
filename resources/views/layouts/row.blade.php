<fieldset class="py-3" data-async>

    @empty(!$title)
        <div class="col p-0">
            <legend class="text-black">{{ $title }}</legend>
        </div>
    @endempty

    {!! $form ?? '' !!}
</fieldset>
