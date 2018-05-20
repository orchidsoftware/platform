@component('platform::partials.fields.group',get_defined_vars())

    <div data-controller="utm">
        <div class="input-group mb-3">
            <input @include('platform::partials.fields.attributes', ['attributes' => $attributes]) data-target="utm.url">
            <div class="input-group-append">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#utm-{{$id}}">Сгенерировать UTM</button>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="utm-{{$id}}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header m-b">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title" id="exampleModalLabel">UTM Generator</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>Источник кампании - <span class="font-bold">utm_source</span></label>
                                    <input type="text" data-target="utm.source"  placeholder="google"
                                           class="form-control">
                                    <small class="help-block">Источник перехода: google, newsletter и т.п.</small>
                                </div>


                                <div class="form-group">
                                    <label>Канал кампании - <span class="font-bold">utm_medium</span></label>
                                    <input type="text" data-target="utm.medium"  placeholder="cpc" class="form-control">
                                    <small class="help-block">Тип трафика: cpc, ppc, banner, email и т.п.</small>
                                </div>

                                <div class="form-group">
                                    <label>Название кампании - <span class="font-bold">utm_campaign</span></label>
                                    <input type="text" data-target="utm.campaign" pattern="[a-zA-Z0-9]+" 
                                           placeholder="sleeping_beds"
                                           class="form-control">
                                    <small class="help-block">Название рекламной кампании</small>
                                </div>

                            </div>


                            <div class="col-md-6">


                                <div class="form-group">
                                    <label>Ключевое слово - <span class="font-bold">utm_term</span></label>
                                    <input type="text" data-target="utm.term" placeholder="Golf ball" class="form-control">
                                    <small class="help-block">Определяет оплачиваемые ключевые слова</small>
                                </div>

                                <div class="form-group">
                                    <label>Содержание кампании - <span class="font-bold">utm_content</span></label>
                                    <input type="text" data-target="utm.content" placeholder="cpc" class="form-control">
                                    <small class="help-block">Дополнительная информация, позволяющая различать объявления
                                    </small>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button type="button" data-action="utm#generate" class="btn btn-primary">Сгенерировать ссылку</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endcomponent


