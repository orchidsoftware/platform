<div data-post-id="{{$post->id}}" class="row">
    <!-- hbox layout -->
    <div class="hbox hbox-auto-xs no-gutters">
    @if(count($type->fields()) > 0)
        <!-- column -->
            <div class="hbox-col">
                <div class="vbox">
                    <div class="wrapper">
                        <div class="tab-content">
                            @foreach($locales as $code => $lang)
                                <div class="tab-pane @if($loop->first) active @endif" id="local-{{$code}}"
                                     role="tabpanel">
                                    {!! generate_form($type->fields(), $post->toArray(), $code, 'content') !!}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- /column -->
    @endif
        <!-- column -->
        <div class="hbox-col wi-col">
            <div class="vbox">
                <div class="row-row">
                    <div class="wrapper">

                        {!! generate_form($type->main(), $post->toArray()) !!}
                        {!! generate_form($type->options(), $post->toArray(), null, 'options') !!}

                        @include('platform::container.posts.locale')
                    </div>
                </div>
            </div>
        </div>
        <!-- /column -->
    </div>
</div>
