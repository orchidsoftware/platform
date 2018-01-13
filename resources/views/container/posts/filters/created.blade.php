<div class="form-group">
    <label class="control-label">{{trans('dashboard::common.filters.date_created')}}</label>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <input type='text' name="start_created_at" id='start_created_at'
                       form="filters"
                       value="{{$request->get('start_created_at')}}" class="form-control datetimepicker"
                       data-date-format="YYYY-MM-DD HH:mm:ss">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <input type='text' name="end_created_at" id='end_created_at' value="{{$request->get('end_created_at')}}"
                       form="filters"
                       class="form-control datetimepicker"
                       data-date-format="YYYY-MM-DD HH:mm:ss">
            </div>
        </div>
    </div>


</div>

<script type="text/javascript">
    $(function () {
        $("#start_created_at").on("dp.change", function (e) {
            $('#end_created_at').data("DateTimePicker").minDate(e.date);
        });
        $("#end_created_at").on("dp.change", function (e) {
            $('#start_created_at').data("DateTimePicker").maxDate(e.date);
        });
    });
</script>







