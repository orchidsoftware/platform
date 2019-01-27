@if($locales->count() > 1)
    <button class="btn btn-link dropdown-item text-uppercase" data-toggle="dropdown" aria-expanded="false">
        <i class="icon-globe m-r-xs"></i> <span id="code-local">{{ key(reset($locales)) }}</span>
    </button>

    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
        @foreach($locales as $code => $lang)
            <a class="dropdown-item"
               href="#local-{{$code}}"
               role="tab"
               data-toggle="tab"
               onclick="document.getElementById('code-local').innerHTML = '{{$code}}';this.classList.remove('active')"
               aria-controls="local-{{$code}}"
               aria-expanded="@if ($loop->first)true @else false @endif">{{$lang['native']}}
            </a>
        @endforeach
    </div>

@endif