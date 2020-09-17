<div class="bg-white rounded-top shadow-sm mb-3">


    <div class="p-4">
        <div class="col col-md-8 mt-6 p-0">

            <h2 class="mt-2 text-dark">
                Get familiar with Orchid and explore its features in the documentation:
            </h2>

            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus finibus lobortis viverra. Nam
                molestie, ex ut ultrices pharetra, leo dolor volutpat neque, a interdum orci eros sed odio. Sed vel
                fringilla diam. Phasellus ut arcu porttitor, volutpat nulla eu, congue magna. Nulla convallis augue est,
                in sodales odio maximus eget. Curabitur metus ligula, tincidunt non aliquet ut, fermentum sit amet diam.
                We hope you love it.
            </p>

            <p>
                The installation includes examples of pages and the use of fields, layers and tables, and more
                on them. <br><strong> Why not explore them?</strong>
            </p>

            <div class="row mb-4">
                <div class="col-xs-12 col-auto">
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
                <div class="col-xs-12 col-auto">
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
                            <li><a href="{{ route('platform.systems.users') }}">Users</a> and <a
                                    href="{{ route('platform.systems.roles') }}"> roles</a></li>
                        @endif
                    </ul>
                </div>
            </div>

        </div>
    </div>


    <div class="row bg-light m-0 p-4 border-top rounded-bottom">


        <div class="col-md-6 my-2">
            <h3 class="text-muted font-thin">
                <x-orchid-icon path="book-open"/>

                <span class="ml-3 text-dark">Explore the documentation</span>
            </h3>
            <p class="ml-md-5">
                Laravel has wonderful documentation covering every aspect of the framework. Whether you're new to
                the framework or have previous experience, we recommend reading all of the documentation from
                beginning to end.
            </p>
        </div>

        <div class="col-md-6 my-2">
            <h3 class="text-muted font-thin">
                <x-orchid-icon path="rocket"/>

                <span class="ml-3 text-dark">Quick start guide</span>
            </h3>
            <p class="ml-md-5">
                For a quick study of the main features, step-by-step tutorials are prepared, which you can
                <a href="https://orchid.software/en/docs/quickstart" target="_blank"> see on the site</a>.
            </p>
        </div>

        <div class="col-md-6 my-2">
            <h3 class="text-muted font-thin">
                <x-orchid-icon path="monitor"/>

                <span class="ml-3 text-dark">Screen</span>
            </h3>
            <p class="ml-md-5">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus finibus lobortis viverra. Nam
                molestie, ex ut ultrices pharetra, leo dolor volutpat neque, a interdum orci eros sed odio. Sed vel
                fringilla diam. Phasellus ut arcu porttitor, volutpat nulla eu, congue magna.
            </p>
        </div>

        <div class="col-md-6 my-2">
            <h3 class="text-muted font-thin">
                <x-orchid-icon path="layers"/>

                <span class="ml-3 text-dark">Layouts</span>
            </h3>
            <p class="ml-md-5">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus finibus lobortis viverra. Nam
                molestie, ex ut ultrices pharetra, leo dolor volutpat neque, a interdum orci eros sed odio. Sed vel
                fringilla diam. Phasellus ut arcu porttitor, volutpat nulla eu, congue magna.
            </p>
        </div>

        <div class="col-md-6 my-2">
            <h3 class="text-muted font-thin">
                <x-orchid-icon path="star"/>

                <span class="ml-3 text-dark">And one more thing</span>
            </h3>
            <p class="ml-md-5">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus finibus lobortis viverra. Nam
                molestie, ex ut ultrices pharetra, leo dolor volutpat neque, a interdum orci eros sed odio. Sed vel
                fringilla diam. Phasellus ut arcu porttitor, volutpat nulla eu, congue magna.
            </p>
        </div>

        <div class="col-md-6 my-2">
            <h3 class="text-muted font-thin">
                <x-orchid-icon path="help"/>

                <span class="ml-3 text-dark">Community</span>
            </h3>
            <div class="ml-md-5">
                <p>Stay up to date on the development of "Orchid Platform" and reach out to the community with these
                    helpful
                    resources.</p>
                <ul class="pl-4 m-0">
                    <li>Follow <a href="https://twitter.com/orchid_platform">@orchid_platform on Twitter</a>.</li>
                    <li>Join <a href="https://t.me/orchid_community">the official Telegram group</a>.</li>
                </ul>
            </div>
        </div>
    </div>

</div>

