@empty(!$announcement)
    <div class="alert alert-warning border-0" role="alert">
        {!! $announcement->getParsedContentAttribute() !!}
    </div>
@endempty