<fieldset class="py-3 d-flex" data-async>

    @empty(!$title)
        <div class="row p-0">
            <legend class="text-black">{{ $title }}</legend>
        </div>
    @endempty

    {!! $form ?? '' !!}
</fieldset>
