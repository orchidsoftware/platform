@if(isset($files["error"]))

    <div class="no-data">
        <h3>{{ $files["error"] }}</h3>
    </div>

@else

    @if(count($files) > 0 )

        @foreach($files as $index => $file)
            <div class="item grid col-sm-3" id="item-{{ $index }}">
            @if($file->type == 'dir')

                <div class="filemanager-item folder"  data-folder="{{ $file->folder->path }}" data-name="{{ $file->name }}">
                    <div class="row full-width centered">
                        <div class="col-sm-4 b-r b-grey icon">
                            <i class="fa fa-folder"></i>
                        </div>
                        <div class="col-sm-8 info">
                            <p>{{ $file->name }}</p>
                            @if($file->folder->permission)
                            <p class="small"> {{ $file->folder->folderCount + $file->folder->fileCount }} item(s)</p>
                            @else
                                <p class="small">Without permission</p>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                @if($file->can)
                    <div class="filemanager-item file"  data-type="{{ $file->mime }}" data-path="{{ $file->path }}" data-asset="{{ $file->asset }}" data-size="{{ $file->size_human }}" {{ ($file->mime == 'image') ? 'data-dimension='.$file->dimensions : '' }} >
                        <div class="row full-width centered">
                            <div class="col-sm-4 b-r b-grey icon">
                                <img src="{{ $file->thumb }}">
                            </div>
                            <div class="col-sm-8 info">
                                <p class="name-file">{{ $file->name }}</p>
                                <p class="small">{{ $file->size_human }}</p>
                            </div>
                        </div>
                    </div>
                @else
                        <div class="filemanager-item error-file">
                            <div class="row full-width centered">
                                <div class="col-sm-12 info">
                                    <p class="name-file">{{ $file->name }}</p>
                                    <p class="small">This file is not Readable</p>
                                </div>
                            </div>
                        </div>
                @endif
           @endif
           </div>
       @endforeach

   @else
       <div class="no-data">
           <h3>There is not files or folders matching your request</h3>
       </div>
   @endif

@endif