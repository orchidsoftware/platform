<div class="map-container" xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-bind="http://www.w3.org/1999/xhtml">
    <div class="g-maps">
    </div>
    <div class="controls">
        <div class="row">
            <div v-for="(point, index) in currentPath.markers" :key="point.coordsStr">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="input-group pull-left">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" v-model="point.visible" v-on:change="currentPath.callUpdateHandlers()" />
                                            Видимая
                                        </label>
                                    </div>
                                </div>
                                <div class="btn-group pull-right">
                                    <a v-on:click="toTop(index)" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-arrow-up"></i></a>
                                    <a v-on:click="toDown(index)" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-arrow-down"></i></a>
                                    <a v-on:click="center(point)" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-map-marker"></i></a>
                                    <a v-on:click="remove(index)" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-remove"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="point.visible" class="panel-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="input-group">
                                    <span class="input-group-addon">{{point.label}}</span>
                                    <input class="form-control" type="text" v-model="point.description">
                                        <span class="input-group-addon">
                                            <img class="pt-icon" v-bind:src="point.icon" alt="">
                                        </span>
                                        <span class="input-group-addon">
                                            <span class="dropdown-toggle" data-toggle="dropdown">
                                                <span class="caret"></span>
                                            </span>
                                            <div class="dropdown-menu pull-right">
                                                <div class="map-icon" v-for="icon in icons" v-on:click="point.icon = icon.icon">
                                                    <span v-bind:class="'flag-icon flag-icon-' + icon.code">
                                                    </span>
                                                    <span>{{icon.label}}</span>
                                                </div>
                                            </div>
                                        </span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input-group bootstrap-timepicker timepicker">
                                    <input type="text" placeholder="Время" v-model="point.time" v-bind:data-index="index" v-bind:date-time="'dt-' + index"  class="form-control input-small" />
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" v-bind:name="fieldName" v-bind:value="currentPath.serial">
</div>