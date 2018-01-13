@foreach($manyForms as $key => $modal)

<div class="modal fade in" id="screen-modal-{{$key}}" role="dialog" aria-labelledby="screen-modal-{{$key}}">
  <div class="modal-dialog" role="document" id="screen-modal-type-{{$key}}">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="title-modal-{{$key}}"></h4>
      </div>
      <div class="modal-body">
          @foreach($modal as $item)
              {!! $item or '' !!}
          @endforeach
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id="submit-modal-{{$key}}" class="btn btn-primary">Apply</button>
      </div>
    </div>
  </div>
</div>
@endforeach


<script>
  $('#title-modal-{{$key}}').html($('#show-button-modal-{{$key}}').data('modalTitle'));
  $('#submit-modal-{{$key}}').attr('formaction',$('#show-button-modal-{{$key}}').data('modalAction'));
  $('#screen-modal-type-{{$key}}').addClass($('#show-button-modal-{{$key}}').data('modalType'));
</script>
