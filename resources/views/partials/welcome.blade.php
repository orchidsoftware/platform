<div class="admin-wrapper">
    <div class="py-4">

        <div class="row">
            <div class="col-md-7 col-sm-12">
                <div class="mb-5 jumbotron">
                    <h1 class="display-5 text-dark font-thin m-b-sm">
                        <x-orchid-icon path="trophy" class="mr-2 mb-3"/>
                        Congratulations!

                        <span
                            class="badge badge-success small v-top bg-primary text-white">{{\Orchid\Platform\Dashboard::VERSION}}</span>
                    </h1>
                    <p class="lead">You have successfully installed the platform, let's get started</p>

                    <p>
                        The installation includes examples of pages and the use of fields, layers and tables, and more
                        on them.
                    </p>

                    <p>
                        <strong> Why not explore them?</strong>
                    </p>

                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <ul class="pl-4 m-0">
                                @if(Route::has('platform.example'))
                                    <li><a href="{{ route('platform.example') }}">Example screen</a></li>
                                @endif
                                @if(Route::has('platform.example.fields'))
                                    <li><a href="{{ route('platform.example.fields') }}">Basic form controls</a></li>
                                @endif
                                @if(Route::has('platform.example.advanced'))
                                    <li><a href="{{ route('platform.example.advanced') }}">Advanced form controls</a>
                                    </li>
                                @endif
                                @if(Route::has('platform.example.editors'))
                                    <li><a href="{{ route('platform.example.editors') }}">Form Text Editors</a></li>
                                @endif
                            </ul>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <ul class="pl-4 m-0">
                                @if(Route::has('platform.example.layouts'))
                                    <li><a href="{{ route('platform.example.layouts') }}">Overview layouts</a></li>
                                @endif
                                @if(Route::has('platform.example.charts'))
                                    <li><a href="{{ route('platform.example.charts') }}">Charts</a></li>
                                @endif
                                @if(Route::has('platform.example.cards'))
                                    <li><a href="{{ route('platform.example.cards') }}">Cards</a>
                                    </li>
                                @endif
                                @if(Route::has('platform.systems.roles') && Route::has('platform.systems.roles'))
                                        <li><a href="{{ route('platform.systems.users') }}">Users</a> and <a href="{{ route('platform.systems.roles') }}"> roles</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-5 col-sm-12 pr-md-5 mt-md-3">
                <div class="mb-5">
                    <h2 class="display-5 text-dark font-thin m-b-sm">
                        <x-orchid-icon path="rocket" class="mr-2 mb-1"/>
                        Quick start
                    </h2>
                    <div class="line line-dashed border-bottom mt-3 mb-3"></div>
                    <p>For a quick study of the main features, step-by-step tutorials are prepared, which you can
                        <a href="https://orchid.software/en/docs/quickstart" target="_blank"> see on the site</a>.</p>
                </div>
                <div class="mb-5">
                    <h2 class="display-5 text-dark font-thin m-b-sm">
                        <x-orchid-icon path="help" class="mr-2 mb-1"/>
                        Community
                    </h2>
                    <div class="line line-dashed border-bottom mt-3 mb-3"></div>
                    <p>Stay up to date on the development of "Orchid Platform" and reach out to the community with these
                        helpful
                        resources.</p>
                    <ul>
                        <li>Follow <a href="https://twitter.com/orchid_platform">@orchid_platform on Twitter</a>.</li>
                        <li>Join <a href="https://t.me/orchid_community">the official Telegram group</a>.</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>
