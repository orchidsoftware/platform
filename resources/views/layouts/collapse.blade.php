<div class="pt-0" data-async>

    <p class="pl-4">
        <a data-toggle="collapse"
           href="#collapse-{{ $slug }}"
           role="button"
           aria-expanded="false"
           aria-controls="collapse-{{ $slug }}">
           {{ __($label) }}
        </a>
    </p>
    <div class="collapse bg-white rounded shadow-sm mb-3 p-4" id="collapse-{{ $slug }}">
        {!! $form ?? '' !!}
    </div>

</div>
