@if(count($item)> 0)
    @foreach($item as $value)
        <tr>
            <td class="text-center">
                <a href="{{ route('dashboard.tools.category.edit',$value->id) }}"><i
                            class="fa fa-bars"></i></a>
            </td>
            <td>{{$delimiter}}{{$value->term->getContent('name')}}</td>
            <td>{{ $value->term->updated_at}}</td>
        </tr>
        @include("dashboard::partials.tools.categoryItem",[
        'item' => $value->allChildrenTerm,
        'delimiter' => $delimiter . $delimiter
        ])
    @endforeach
@endif