<div class="dropdown">
    <button class="btn btn-sm btn-link dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
        <i class="icon-filter"></i>
    </button>
    <div class="dropdown-menu">
        <div class="wrapper-sm">

            <div id="datetimepicker-filter"></div>

            <script type="text/javascript">
                $(function () {
                    $('#datetimepicker-filter').datetimepicker({
                        inline: true,
                        sideBySide: false
                    });
                });
            </script>

            <div class="line line-dashed b-b line-lg"></div>
            <button type="submit" class="btn btn-default btn-sm w-full">Применить</button>
        </div>
    </div>
</div>