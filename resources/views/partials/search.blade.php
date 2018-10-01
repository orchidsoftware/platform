@empty(!Dashboard::getGlobalSearch()->all())
    <div class="dropdown position-relative" data-controller="layouts--search">
        <div class="input-icon m-l-sm">
            <input
                   data-action="keyup->layouts--search#query blur->layouts--search#blur focus->layouts--search#focus"
                   type="text" class="form-control input-sm  no-border rounded padder"
                   placeholder="What to search..."
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            >
            <div class="input-icon-addon">
                <i class="icon-magnifier"></i>
            </div>
        </div>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow"
             x-placement="start-left" id="search-result">
        </div>
    </div>
@endempty