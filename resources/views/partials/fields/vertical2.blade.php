<div class="form-group mb-0">
    @if($attributes->has('title'))
        <label for="{{$attributes->get('id')}}" class="form-label">{{$attributes->get('title')}}
            @if($attributes->has('required'))
                <sup class="text-danger">*</sup>
            @endif

            <x-orchid-popover :content="$attributes->get('popover')"/>
        </label>
    @endif

    {!! $field !!}

    @if($errors->has($attributes->get('oldName')))
        <div class="invalid-feedback d-block">
            <small>{{$errors->first($attributes->get('oldName'))}}</small>
        </div>
    @elseif($attributes->has('help'))
        <small class="form-text text-muted">{!! $attributes->get('help') !!}</small>
    @endif
</div>

@if($attributes->get('hr'))
    <div class="line line-dashed border-bottom my-3"></div>
@endif
