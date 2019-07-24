<div class="row b-t">
    @forelse($result as $item)

        <a href="{{$item->searchUrl()}}" class="block wrapper-sm dropdown-item" style="font-size: 0.82857rem;">

            @empty(!$item->searchAvatar())
                <span class="pull-left thumb-xs avatar m-r-sm">
                  <img src="{{$item->searchAvatar()}}" alt="{{$item->searchTitle()}}">
                  {{-- <i class="on b-white bottom"></i> --}}
                </span>
            @endempty

            <span class="clear">
                <span class="text-ellipsis">{{$item->searchTitle()}}</span>
                <small class="text-muted clear text-ellipsis">
                    {{$item->searchSubTitle()}}
                </small>
            </span>
        </a>

    @empty

        <p class="ml-3 mr-3 mb-0 text-center">
            {{ __('There are no records in this view.') }}
        </p>

    @endforelse

    @includeWhen($result instanceof \Illuminate\Contracts\Pagination\Paginator && $result->total() > 0,
        'platform::layouts.pagination',
        ['paginator' => $result]
      )

</div>