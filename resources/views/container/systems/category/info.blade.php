<div class="wrapper-md ">

    <div class="padder-md">
    <input type="hidden" name="taxonomy" value="category">
    <input type="hidden"
           name="term_id"
           @if($termTaxonomy->exists)value="{{$termTaxonomy->term->id}}"
           @else value="0" @endif>

    <div class="form-group">
        <label class="control-label">{{trans('dashboard::systems/category.parent')}}</label>

        <select data-placeholder="Select Category" name="parent_id" class="select2 form-control">

            <option value="0">{{trans('dashboard::systems/category.not_parrent')}}</option>

            @foreach($category as  $value)
                <option value="{{$value->id}}"
                        @if($termTaxonomy->exists && $termTaxonomy->parent_id == $value->id) selected @endif >
                        {{$value->term->getContent('name')}}
                </option>
            @endforeach
        </select>
    </div>


    <div class="form-group m-t-md">
        <label class="control-label">{{trans('dashboard::systems/category.slug')}}</label>
        <input type="text" name="slug"
               value="{{!$termTaxonomy->exists ? null : optional($termTaxonomy->term)->slug}}"
               required class="form-control" placeholder="news">
    </div>
    </div>

</div>
