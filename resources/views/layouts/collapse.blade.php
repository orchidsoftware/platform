<div class="pt-0" data-async>

    <p>
        <a data-toggle="collapse"
           href="#collapse-{{ $slug }}"
           role="button"
           aria-expanded="false"
           aria-controls="collapse-{{ $slug }}">
           {{ __($label) }}
        </a>
    </p>
    <div class="collapse" id="collapse-{{ $slug }}">
        {!! $form ?? '' !!}
    </div>

</div>
