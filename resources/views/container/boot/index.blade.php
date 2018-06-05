@section('controller','components--boot')
@section('aside')

    <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
        <span>Выберите модель:</span>
    </li>

    @foreach($models as $name => $value)

        <li>
            <a href="{{route('platform.boot.index',$name)}}">
                <i class="icon-folder"></i>
                <span class="text-ellipsis"> {{ $name }}</span>
            </a>
        </li>

    @endforeach
@endsection


<div style="min-height: calc(100vh - 80px);display: block;
     position: absolute;">
    <div class="hbox hbox-auto-xs hbox-auto-sm">

        <div class="hbox-col w-xxl bg-white-only b-r bg-auto no-border-xs">

            <div class="wrapper-md">

                @isset($model)
                    <div class="form">

                        <div class="form-group">
                            <h5 class="text-black font-thin">Special Columns :</h5>
                            <small>Choose unique column functions</small>

                            <div class="padder m-t-md">
                                <div class="checkbox m-t-sm">
                                    <label class="i-checks">
                                        <input type="checkbox" value="1" name="content[en][free]">
                                        <i></i> Use Timestamps
                                    </label>
                                </div>
                                <div class="checkbox m-t-sm">
                                    <label class="i-checks">
                                        <input type="checkbox" value="1" name="content[en][free]">
                                        <i></i> Use Timestamps with Timezone
                                    </label>
                                </div>
                                <div class="checkbox m-t-sm">
                                    <label class="i-checks">
                                        <input type="checkbox" value="1" name="content[en][free]">
                                        <i></i> Use Soft Deletes
                                    </label>
                                </div>
                                <div class="checkbox m-t-sm">
                                    <label class="i-checks">
                                        <input type="checkbox" value="1" name="content[en][free]">
                                        <i></i> Use Remember Token
                                    </label>
                                </div>
                            </div>
                            <small class="form-text text-danger none"
                                   id="errors.label">{{trans('platform::common.validation.required')}}</small>
                        </div>

                    </div>
                @else

                    <p>Выберите или создайте модель</p>

                @endisset

            </div>

        </div>



        <div class="hbox-col bg-white">
            <div class="row">
                @isset($model)
                <div class="col-sm-12">


                    <div class="wrapper-lg b">
                        <div class="container">
                            <h3 class="font-thin text-black m-b-md">"History" Columns</h3>


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
                                           class="form-control"
                                           required
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

                    <div class="table-responsive">
                        <table class="table m-b-none">
                            <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Fillable</th>
                                <th class="text-center">Guarded</th>
                                <th class="text-center">Nullable</th>
                                <th class="text-center">Unique</th>
                                <th class="text-center">Hidden</th>
                                <th class="text-center"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-center">id</td>
                                <td class="text-center">
                                    <select name="model" class="form-control" required>
                                      @foreach($fieldTypes as $key => $type)
                                            <option value="{{$key}}">{{$type}}</option>
                                      @endforeach
                                    </select>
                                </td>
                                <td class="text-center">
                                    <label class="i-checks">
                                        <input type="checkbox" value="1" name="content[en][free]">
                                        <i></i>
                                    </label>
                                </td>
                                <td class="text-center">
                                    <label class="i-checks">
                                        <input type="checkbox" value="1" name="content[en][free]">
                                        <i></i>
                                    </label>
                                </td>
                                <td class="text-center">
                                    <label class="i-checks">
                                        <input type="checkbox" value="1" name="content[en][free]">
                                        <i></i>
                                    </label>
                                </td>
                                <td class="text-center">
                                    <label class="i-checks">
                                        <input type="checkbox" value="1" name="content[en][free]">
                                        <i></i>
                                    </label>
                                </td>
                                <td class="text-center">
                                    <label class="i-checks">
                                        <input type="checkbox" value="1" name="content[en][free]">
                                        <i></i>
                                    </label>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger"><i class="icon-trash"></i></button>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>

                    <div class="wrapper-lg b">
                        <div class="container">
                            <h3 class="font-thin text-black  m-b-md">"History" Relationships</h3>


                            <div class="form-inline">
                                <div class="form-group mb-2">
                                    <div>
                                        Relationships<br>
                                        <p class="text-muted">Determine the relationships for this model</p>
                                    </div>
                                </div>
                                <div class="form-group mx-sm-3 mb-2">
                                    <label class="sr-only">Choose Model:</label>
                                    <input type="text"
                                           data-target="components--boot.relation"
                                           required
                                           class="form-control"
                                           placeholder="Model">
                                </div>
                                <button type="button"
                                        data-action="components--boot#addRelation"
                                        class="btn btn-default mb-2">
                                    Add Columns
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table m-b-none">
                            <thead>
                            <tr>
                                <th class="text-center">Model</th>
                                <th class="text-center">Relationship Type</th>
                                <th class="text-center">Local Key</th>
                                <th class="text-center">Related Key</th>
                                <th class="text-center"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-center">id</td>
                                <td class="text-center">
                                    <select name="model" class="form-control">
                                        @foreach ($relationTypes as $key => $relation)
                                            <option value="{{$key}}">{{$relation}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="text-center">
                                    <select name="model"
                                            class="form-control">
                                        <option value="null">Don't Use</option>
                                        <option value="id">id</option>
                                        <option value="name">name</option>
                                        <option value="email">email</option>
                                        <option value="password">password</option>
                                        <option value="test">test</option>
                                        <option value="trhrhtrhrt">trhrhtrhrt</option>
                                    </select>
                                </td>
                                <td class="text-center">
                                    <select name="model"
                                            class="form-control">
                                        <option value="null">Don't Use</option>
                                        <option value="id">id</option>
                                        <option value="name">name</option>
                                        <option value="email">email</option>
                                        <option value="password">password</option>
                                        <option value="test">test</option>
                                        <option value="trhrhtrhrt">trhrhtrhrt</option>
                                    </select>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger"><i class="icon-trash"></i></button>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
                @endisset
            </div>
        </div>


    </div>

</div>