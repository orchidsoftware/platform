<div class="c-stage__panel u-p-medium">

    <p class="u-text-mute u-text-uppercase u-text-small u-mb-xsmall">Description</p>
    <p class="u-mb-medium">What we have done so far is brighten the colour palette, created new “easy to understand”
        icons, overall organization of the page and also worked on the copy! After first user tesing we got some great
        results - users that went through the page could navigate easily and explain Tapdaq’s services right after.</p>

    <p class="u-text-mute u-text-uppercase u-text-small u-mb-xsmall">Resources</p>
    <div class="row u-mb-medium">
        <div class="col-md-6 col-lg-4">
            <ul>
                <li class="u-mb-xsmall u-text-small u-color-primary">
                    <i class="fa fa-file-image-o u-text-mute u-mr-xsmall"></i>Previous-design.png
                </li>
                <li class="u-mb-xsmall u-text-small u-color-primary">
                    <i class="fa fa-file-text-o u-text-mute u-mr-xsmall"></i>Marketing-Materials-2018.zip
                </li>
                <li class="u-mb-xsmall u-text-small u-color-primary">
                    <i class="fa fa-file-text-o u-text-mute u-mr-xsmall"></i>All-PSD-Files.zip
                </li>
            </ul>
        </div>

        <div class="col-md-6 col-lg-8">
            <ul>
                <li class="u-mb-xsmall u-text-small u-color-primary">
                    <i class="fa fa-file-text-o u-text-mute u-mr-xsmall"></i>Brief.docx
                </li>
                <li class="u-mb-xsmall u-text-small u-color-primary">
                    <i class="fa fa-file-text-o u-text-mute u-mr-xsmall"></i>Copy-for-landing-page-by-Jason.docx
                </li>
            </ul>
        </div>
    </div>

    <p class="u-text-mute u-text-uppercase u-text-small u-mb-xsmall">Main goal of this stage</p>

    <div class="row">
        <div class="col-md-6 col-lg-4">
            <ul>
                <li class="u-mb-xsmall u-text-small u-color-primary">
                    <i class="fa fa-check u-color-info u-text-mute u-mr-xsmall"></i>New colour palette
                </li>
                <li class="u-mb-xsmall u-text-small u-color-primary">
                    <i class="fa fa-check u-color-info u-text-mute u-mr-xsmall"></i>Brand new and cool icons
                </li>
            </ul>
        </div>

        <div class="col-md-6 col-lg-4">
            <ul>
                <li class="u-mb-xsmall u-text-small u-color-primary">
                    <i class="fa fa-check u-color-info u-text-mute u-mr-xsmall"></i>New copy
                </li>
            </ul>
        </div>
    </div>

</div>


<div class="avatar-group d-flex justify-content-start">
    @foreach($users as $user)
        <a href="{{ $user->url() }}" class="avatar thumb-xs"
           data-controller="layouts--tooltip"
           data-action="mouseover->layouts--tooltip#mouseOver"
           data-toggle="tooltip"
           data-placement="top"
           title="{{ $user->title() }}">
            <img src="{{ $user->image() }}"
                 class="avatar-img rounded-circle b bg-light"
                 alt="{{ $user->title() }}">
        </a>
    @endforeach
</div>


<style>
    .avatar-group .thumb-xs + .thumb-xs {
        margin-left: -.40625rem;
    }
</style>

