<div class="card card-note alert-warning mt-2 mb-2">
    <div class="d-flex no-gutters card-header align-items-center bg-white">
        <div class="col">
            {!! $profile !!}
        </div>
        <div class="col-auto mr-auto d-flex align-items-center">
            <span title="2019-12-12">{{ $date }}</span>
            <div class="ml-1 dropdown card-options">
                <button class="btn btn-link btn-sm dropdown-toggle dropdown-item p-2" type="button"
                        id="note-dropdown-button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    <i class="icon-options-vertical"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">
                    <a class="dropdown-item" href="#">Edit</a>
                    <a class="dropdown-item text-danger" href="#">Delete</a>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        {!! $message !!}
    </div>
</div>
