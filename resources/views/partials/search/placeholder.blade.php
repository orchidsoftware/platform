<div data-search-target="placeholder"
     class="d-flex flex-column gap-2 list-group d-none">
    @foreach(range(0, 2) as $i)
        <div class="p-2 d-flex gap-3 align-items-center placeholder-wave opacity-50">

            <div class="thumb-sm rounded overflow-hidden">
                <span class="placeholder d-block w-100 h-100 ratio ratio-1x1"></span>
            </div>

            <div class="d-flex flex-column flex-grow-1 gap-2">
                <span class="placeholder col-8 rounded"></span>
                <small class="placeholder col-5 rounded text-muted"></small>
            </div>

        </div>
    @endforeach
</div>
