<div class="form-group">
    <label class="control-label">{{trans('dashboard::common.filters.status')}}</label>
    <select form="filters" name="status" class="form-control">
        <option></option>
        @foreach($behavior->status() as $key => $status)
            <option value="{{$key}}" @if($key == $request->get('status')) selected @endif>{{$status}}</option>
        @endforeach
    </select>
</div>
