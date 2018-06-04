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
                                        <input type="checkbox" value="230" name="content[en][free]" title="Free"
                                               placeholder="Event for free" lang="en" checked="">
                                        <i></i> Use Timestamps
                                    </label>
                                </div>
                                <div class="checkbox m-t-sm">
                                    <label class="i-checks">
                                        <input type="checkbox" value="230" name="content[en][free]" title="Free"
                                               placeholder="Event for free" lang="en" checked="">
                                        <i></i> Use Timestamps with Timezone
                                    </label>
                                </div>
                                <div class="checkbox m-t-sm">
                                    <label class="i-checks">
                                        <input type="checkbox" value="230" name="content[en][free]" title="Free"
                                               placeholder="Event for free" lang="en" checked="">
                                        <i></i> Use Soft Deletes
                                    </label>
                                </div>
                                <div class="checkbox m-t-sm">
                                    <label class="i-checks">
                                        <input type="checkbox" value="230" name="content[en][free]" title="Free"
                                               placeholder="Event for free" lang="en" checked="">
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
                                    <input type="text" class="form-control" placeholder="Column">
                                </div>
                                <button type="submit" class="btn btn-default mb-2">Add Columns</button>
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
                                    <select name="model" class="form-control">
                                        <option value="">Select Type</option>
                                        <option value="4">boolean</option>
                                        <option value="7">dateTime</option>
                                        <option value="15">increments</option>
                                        <option value="16">integer</option>
                                        <option value="36">string</option>
                                        <option value="37">text</option>
                                        <option value="44">unsignedInteger</option>
                                        <option value="1">bigIncrements</option>
                                        <option value="2">bigInteger</option>
                                        <option value="3">binary</option>
                                        <option value="5">char</option>
                                        <option value="6">date</option>
                                        <option value="8">dateTimeTz</option>
                                        <option value="9">decimal</option>
                                        <option value="10">double</option>
                                        <option value="11">enum</option>
                                        <option value="12">float</option>
                                        <option value="13">geometry</option>
                                        <option value="14">geometryCollection</option>
                                        <option value="17">ipAddress</option>
                                        <option value="18">json</option>
                                        <option value="19">jsonb</option>
                                        <option value="20">lineString</option>
                                        <option value="21">longText</option>
                                        <option value="22">macAddress</option>
                                        <option value="23">mediumIncrements</option>
                                        <option value="24">mediumInteger</option>
                                        <option value="25">mediumText</option>
                                        <option value="26">morphs</option>
                                        <option value="27">multiLineString</option>
                                        <option value="28">multiPoint</option>
                                        <option value="29">multiPolygon</option>
                                        <option value="30">nullableMorphs</option>
                                        <option value="31">nullableTimestamps</option>
                                        <option value="32">point</option>
                                        <option value="33">polygon</option>
                                        <option value="34">smallIncrements</option>
                                        <option value="35">smallInteger</option>
                                        <option value="38">time</option>
                                        <option value="39">timeTz</option>
                                        <option value="40">tinyInteger</option>
                                        <option value="41">timestamp</option>
                                        <option value="42">timestampTz</option>
                                        <option value="43">unsignedBigInteger</option>
                                        <option value="45">unsignedMediumInteger</option>
                                        <option value="46">unsignedSmallInteger</option>
                                        <option value="47">unsignedTinyInteger</option>
                                        <option value="48">uuid</option>
                                    </select>
                                </td>
                                <td class="text-center">
                                    <label class="i-checks">
                                        <input type="checkbox" value="230" name="content[en][free]" title="Free"
                                               placeholder="Event for free" lang="en" checked="">
                                        <i></i>
                                    </label>
                                </td>
                                <td class="text-center">
                                    <label class="i-checks">
                                        <input type="checkbox" value="230" name="content[en][free]" title="Free"
                                               placeholder="Event for free" lang="en" checked="">
                                        <i></i>
                                    </label>
                                </td>
                                <td class="text-center">
                                    <label class="i-checks">
                                        <input type="checkbox" value="230" name="content[en][free]" title="Free"
                                               placeholder="Event for free" lang="en" checked="">
                                        <i></i>
                                    </label>
                                </td>
                                <td class="text-center">
                                    <label class="i-checks">
                                        <input type="checkbox" value="230" name="content[en][free]" title="Free"
                                               placeholder="Event for free" lang="en" checked="">
                                        <i></i>
                                    </label>
                                </td>
                                <td class="text-center">
                                    <label class="i-checks">
                                        <input type="checkbox" value="230" name="content[en][free]" title="Free"
                                               placeholder="Event for free" lang="en" checked="">
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
                                    <input type="text" class="form-control" placeholder="Model">
                                </div>
                                <button type="submit" class="btn btn-default mb-2">Add Columns</button>
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
                                        <option value="">Select Relation</option>
                                        <option value="1">One to One (hasOne)</option>
                                        <option value="2">One to Many (hasMany)</option>
                                        <option value="3">Many to Many (belongsToMany)</option>
                                        <option value="4">Has Many Through (belongsToMany)</option>
                                        <option value="5">Polymorphic (morphMany)</option>
                                        <option value="6">Many to Many Polymorphic (morphedByMany)</option>
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
            </div>
        </div>
    </div>

</div>