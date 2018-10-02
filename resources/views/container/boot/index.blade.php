<div data-controller="components--boot" class=" m-b">
    @if(count($models))
        <div class="nav-tabs-alt">
            <ul class="nav nav-tabs" role="tablist">
                @foreach($models as $name => $value)
                    <li class="nav-item">
                        <a href="{{route('platform.bulldozer.index',$name)}}"
                           class="nav-link {{active(route('platform.bulldozer.index',$name))}}">
                            <i class="icon-folder m-r-xs"></i> {{ $name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    @isset($model)

        <div class="row padder-v">
            <div class="col-sm-12">

                <div class="wrapper">
                    <div class="container">

                        <div class="form-inline">
                            <div class="form-group mb-2">
                                <div>
                                    Columns<br>
                                    <p class="text-muted">Determine the columns for your model</p>
                                </div>
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                                <label class="sr-only">Columns</label>
                                <input type="text"
                                       data-target="components--boot.column"
                                       data-action="keypress->components--boot#addColumn"
                                       class="form-control"
                                       placeholder="Column">
                            </div>
                            <button type="button"
                                    data-action="components--boot#addColumn"
                                    class="btn btn-default mb-2">
                                Add Columns
                            </button>
                        </div>
                    </div>
                </div>


                <table class="table m-b-none">
                    <thead>
                    <tr>
                        <th class="text-left" width="35%">Name</th>
                        <th class="text-center" width="50%">Type</th>
                        <th class="text-center" width="5%">Fillable</th>
                        <th class="text-center" width="5%">Guarded</th>
                        <th class="text-center" width="5%">Nullable</th>
                        <th class="text-center" width="5%">Unique</th>
                        <th class="text-center" width="5%">Hidden</th>
                    </tr>
                    </thead>
                    <tbody id="boot-container-column">
                    @foreach($model->get('columns',[]) as $column)
                        @include('platform::partials.boot.column', [
                            'column' => $column,
                            'relationTypes' => $relationTypes,
                           ])
                    @endforeach

                    </tbody>
                </table>


            </div>
        </div>

    @else
        <div class="app-content-center">
            <p>Выберите или создайте модель</p>
        </div>
    @endisset

</div>

@isset($model)
<div class="">
    <div class="row padder-v">
        <div class="col-sm-12">
            <div class="wrapper">
                <div class="container">
                    <div class="form-inline">
                        <div class="form-group mb-2">
                            <div>
                                Relationships<br>
                                <p class="text-muted">Determine the relationships for this model</p>
                            </div>
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <label class="sr-only">Choose Model:</label>

                            <select
                                    class="form-control w-full"
                                    data-target="components--boot.relation"
                            >
                                <option>Select Model</option>
                                @foreach($models as $name => $value)
                                    <option value="{{$name}}">{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button"
                                data-action="components--boot#addRelation"
                                class="btn btn-default mb-2">
                            Add Columns
                        </button>
                    </div>
                </div>
            </div>


            <table class="table m-b-none">
                <thead>
                <tr>
                    <th class="text-center">Model</th>
                    <th class="text-center">Relationship Type</th>
                    <th class="text-center">Local Key</th>
                    <th class="text-center">Related Key</th>
                </tr>
                </thead>
                <tbody id="boot-container-relationship">
                @foreach($model->get('relations',[]) as $relation)
                    @include('platform::partials.boot.relationship', [
                        'model' => $model,
                        'relation' => $relation,
                        'columns' => $model ? $model->get('columns',[]) : [],
                        'relationTypes' => $relationTypes
                    ])
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endisset


@push('scripts')
    <script type="text/x-tmpl" id="boot-template-column">
        @include('platform::partials.boot.column', [
            'column' => [],
            'fieldTypes' => $fieldTypes
        ])
    </script>


    <script type="text/x-tmpl" id="boot-template-relationship">
        @include('platform::partials.boot.relationship', [
            'relations' => [],
            'columns' => $model ? $model->get('columns',[]) : [],
            'relationTypes' => $relationTypes
        ])
    </script>
@endpush