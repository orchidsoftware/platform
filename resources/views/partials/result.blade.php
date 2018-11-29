@forelse($results as $group)

    @empty(!$group['label'])
        <div class="hidden-folded padder m-t-xs m-b-xs text-muted text-xs">{{$group['label']}}</div>
    @endempty

    @foreach($group['result'] as $item)
        <a href="{{$item->url}}" class="block wrapper-sm dropdown-item">

            @empty(!$item->avatar)
                <span class="pull-left thumb-xs avatar m-r-sm">
                  <img src="{{$item->avatar}}" alt="{{$item->title}}">
                  {{-- <i class="on b-white bottom"></i> --}}
                </span>
            @endempty

            <span class="clear">
                <span class="text-ellipsis">{{$item->title}}</span>
                <small class="text-muted clear text-ellipsis">
                    {{$item->subTitle}}
                </small>
            </span>
        </a>
    @endforeach

    @empty

        <p class="ml-3 mr-3 mb-0 text-center">
            {{ __('There are no records in this view.') }}
        </p>

@endforelse