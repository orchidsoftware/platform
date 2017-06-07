<div class="form-group">
    <label class="control-label">Дата создания</label>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <input type='text' name="start_created_at" id='start_created_at'
                       value="{{$request->get('start_created_at')}}" class="form-control"/>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <input type='text' name="end_created_at" id='end_created_at' value="{{$request->get('end_created_at')}}"
                       class="form-control"/>
            </div>
        </div>
    </div>


</div>

<script type="text/javascript">
    $(function () {
        $('#start_created_at').datetimepicker({
            format: 'YYYY-MM-DD',
        });
        $('#end_created_at').datetimepicker({
            format: 'YYYY-MM-DD',
            useCurrent: false
        });
        $("#start_created_at").on("dp.change", function (e) {
            $('#end_created_at').data("DateTimePicker").minDate(e.date);
        });
        $("#end_created_at").on("dp.change", function (e) {
            $('#start_created_at').data("DateTimePicker").maxDate(e.date);
        });
    });
</script>







