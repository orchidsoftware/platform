@empty(!$announcement)
    <div class="alert alert-info b-b m-n" role="alert">
        <div class="container">
            {!! $announcement->getParsedContentAttribute() !!}
        </div>
    </div>
@endempty