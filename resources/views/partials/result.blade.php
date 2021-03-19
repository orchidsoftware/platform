@section('search', $query)

@empty(!$radios)

        {!! $radios !!}

@endempty

<div class="bg-white shadow-sm rounded mb-3">
    @forelse($results as $item)

        <a href="{{$item->url()}}" class="block py-2 px-3 dropdown-item" style="font-size: 0.85em;">

            @empty(!$item->image())
                <span class="pull-left thumb-xs rounded me-3">
                  <img src="{{$item->image()}}" alt="{{$item->title()}}">
                </span>
            @endempty

            <span class="clear">
                <span class="text-ellipsis">{{$item->title()}}</span>
                <small class="text-muted clear text-ellipsis">
                    {{$item->subTitle()}}
                </small>
            </span>
        </a>
    @empty

        <div class="text-center pt-5 pb-5 w-100">
            <h3 class="fw-light">
                <x-orchid-icon path="magnifier-remove" class="block mb-3 center"/>

                {{ __('Nothing found.') }}
            </h3>

            {{ __('Try changing the query or type.') }}
        </div>
    @endforelse

    <div class="mt-2">
        @includeWhen($results instanceof \Illuminate\Contracts\Pagination\Paginator && $results->isNotEmpty(),
            'platform::layouts.pagination',
            ['paginator' => $results]
          )
    </div>
</div>


