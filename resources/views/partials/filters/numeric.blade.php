<div class="dropdown">
    <button class="btn btn-link dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="icon-filter"></i>
    </button>
    <div class="dropdown-menu">
        <form class="wrapper-sm" accept-charset="utf-8" method="get">
            <div class="form-group m-b">
                <input type="number" name="?filter[{{$th->column}}]" class="form-control form-control-sm" required placeholder="Фильтр">
            </div>
            <div class="radio">
                <label class="i-checks i-checks-sm">
                    <input type="radio" name="a">
                    <i></i>
                    Равно
                </label>
            </div>
            <div class="radio">
                <label class="i-checks i-checks-sm">
                    <input type="radio" name="a">
                    <i></i>
                    Больше
                </label>
            </div>
            <div class="radio">
                <label class="i-checks i-checks-sm">
                    <input type="radio" name="a">
                    <i></i>
                    Меньше
                </label>
            </div>

            <div class="line line-dashed b-b line-lg"></div>
            <button type="submit" class="btn btn-default btn-sm w-full">Применить</button>
        </form>
    </div>
</div>