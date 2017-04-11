@extends('dashboard::layouts.dashboard')


@section('title',trans('dashboard::marketing/utm.title'))
@section('description',trans('dashboard::marketing/utm.description'))


@section('content')


    <section class="wrapper" id="utm-generate">
        <div class="bg-white-only bg-auto no-border-xs">


            <form v-on:submit.prevent="generate">
                <div class="wrapper-lg">


                    <div class="form-group form-group-default">
                        <label class="font-bold">Целевой url</label>
                        <div class="controls">
                            <input type="url" v-model="utm_url" required placeholder="https://google.com"
                                   class="form-control"
                                   id="utm_url">
                        </div>
                    </div>


                    <div class="row wrapper-lg">

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Источник кампании - <span class="font-bold">utm_source</span></label>
                                <input type="text" v-model="utm_source" required placeholder="google"
                                       class="form-control">
                                <small class="help-block">Источник перехода: google, newsletter и т.п.</small>
                            </div>


                            <div class="form-group">
                                <label>Канал кампании - <span class="font-bold">utm_medium</span></label>
                                <input type="text" v-model="utm_medium" required placeholder="cpc" class="form-control">
                                <small class="help-block">Тип трафика: cpc, ppc, banner, email и т.п.</small>
                            </div>

                            <div class="form-group">
                                <label>Название кампании - <span class="font-bold">utm_campaign</span></label>
                                <input type="text" v-model="utm_campaign" pattern="[a-zA-Z0-9]+" required
                                       placeholder="sleeping_beds"
                                       class="form-control">
                                <small class="help-block">Название рекламной кампании</small>
                            </div>

                        </div>


                        <div class="col-md-6">


                            <div class="form-group">
                                <label>Ключевое слово - <span class="font-bold">utm_term</span></label>
                                <input type="text" v-model="utm_term" placeholder="Golf ball" class="form-control">
                                <small class="help-block">Определяет оплачиваемые ключевые слова</small>
                            </div>

                            <div class="form-group">
                                <label>Содержание кампании - <span class="font-bold">utm_content</span></label>
                                <input type="text" v-model="utm_content" placeholder="cpc" class="form-control">
                                <small class="help-block">Дополнительная информация, позволяющая различать объявления
                                </small>
                            </div>


                            <div class="btn-group m-t-md">
                                <button v-on:click="generate()" type="submit" class="btn btn-info">Сгенерировать
                                    ссылку
                                </button>
                                <button type="reset" class="btn btn-default">Очистить форму</button>
                            </div>

                        </div>


                    </div>


                    <div class="padder-v">
                        <label>Сгенерированная ссылка:</label>
                        <p>
                            <code v-html="link" readonly id="link" class="text-dark"></code>
                        </p>
                    </div>


                </div>

            </form>


        </div>
    </section>


@stop



@push('scripts')
<script>
    $(function () {


        const utm = new Vue({
            'el': '#utm-generate',
            data: {
                utm_url: '',
                utm_source: '',
                utm_medium: '',
                utm_campaign: '',
                utm_term: '',
                utm_content: '',
                link: '',
            },
            methods: {
                generate: function () {

                    this.link = this.utm_url;

                    this.addParm('utm_source', this.utm_source);
                    this.addParm('utm_medium', this.utm_medium);
                    this.addParm('utm_campaign', this.utm_campaign);
                    this.addParm('utm_term', this.utm_term);
                    this.addParm('utm_content', this.utm_content);

                    return false;
                },
                slugify: function (text) {
                    return text.toString().toLowerCase().trim()
                        .replace(/\s+/g, '-')           // Replace spaces with -
                        .replace(/&/g, '-and-')         // Replace & with 'and'
                        .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                        .replace(/\-\-+/g, '-');        // Replace multiple - with single -
                },
                addParm: function (name, value) {

                    value = this.slugify(value);

                    if ((value.trim()).length == 0) {
                        return;
                    }

                    var re = new RegExp("([?&]" + name + "=)[^&]+", "");

                    function add(sep) {
                        utm.link += sep + name + "=" + encodeURIComponent(value);
                    }

                    function change() {
                        utm.link = utm.link.replace(re, "$1" + encodeURIComponent(value));
                    }

                    if (this.link.indexOf("?") === -1) {
                        add("?");
                    } else {
                        if (re.test(this.link)) {
                            change();
                        } else {
                            add("&");
                        }
                    }
                }

            }
        });
    });

</script>
@endpush
