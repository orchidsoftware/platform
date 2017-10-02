<div class="wrapper-md">

    @foreach($info as $name => $item)
        <table class="table">
            <caption class="font-bold text-black">{{$name}}</caption>
            <tbody>
            @foreach($item as $key => $value)

                <tr>
                    <td><span class="text-muted">{{$key}}</span></td>

                    <td class="text-right text-dark">
                        @if(!is_array($value))
                            {{$value}}
                        @else
                            {{implode(', ',$value)}}
                        @endif
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
    @endforeach

</div>
