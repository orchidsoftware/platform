@if(count($item)> 0)
    @foreach($item as $value)
        <tr>
            <td class="text-center">
                <a href="{{ route('platform.systems.category.edit',$value->id) }}">
                    <i class="icon-menu"></i>
                </a>
            </td>
            <td>{{$delimiter}}{{$value->term->getContent('name')}}</td>
            <td>{{ $value->term->updated_at}}</td>
        </tr>

        @include("platform::partials.systems.categoryItem",[
            'item' => $value->allChildrenTerm,
            'delimiter' => $delimiter . $delimiter
        ])
    @endforeach
@endif
