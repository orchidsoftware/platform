@section('search', $query)

@empty(!$radios)
    <div class="row b-b v-center pl-3 pr-4">
        {!! $radios !!}
    </div>
@endempty

<div class="row">
    @forelse($results as $item)

        <a href="{{$item->searchUrl()}}" class="block wrapper-sm dropdown-item" style="font-size: 0.85em;">

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

        <div class="text-center bg-white pt-5 pb-5 w-full">
            <h3 class="font-thin">
                <i class="icon-magnifier-remove block m-b"></i>
                {{ __('Nothing found.') }}
            </h3>

            {{ __('Try changing the query or type.') }}
        </div>


    @endforelse

    @includeWhen($results instanceof \Illuminate\Contracts\Pagination\Paginator && $results->total() > 0,
        'platform::layouts.pagination',
        ['paginator' => $results]
      )

</div>
