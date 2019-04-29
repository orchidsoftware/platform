<script>
    $(document).ready(function () {
        $('.dropdown-menu a.dropdown-toggle').on('click', function () {
            var $el = $(this);
            $el.toggleClass('active-dropdown');
            var $parent = $(this).offsetParent(".dropdown-menu");
            if (!$(this).next().hasClass('show')) {
                $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
            }
            var $subMenu = $(this).next(".dropdown-menu");
            $subMenu.toggleClass('show');

            if (!$parent.parent().hasClass('navbar-nav')) {
                $el.next().css({"top": $el[0].offsetTop, "left": $parent.outerWidth() - 4});
            }

            return false;
        });

        $('.dropdown-menu').click(function(event) {
            event.stopPropagation();
        });
    });

</script>

<div class="row" data-controller="screen--filter">
    <div class="col-md-12">
        <div class="btn-group" role="group">
            <button class="btn btn-link p-0 dropdown-toggle"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false">
                <i class="icon-filter"></i>
                Add condition
            </button>

            <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow"
                 aria-labelledby="navbarDropdownMenuLink"
                 data-turbolinks-permanent
            >
                @foreach($filters as $filter)
                    @if($filter->display)
                        <a class="dropdown-item dropdown-toggle" href="#">
                            {{ $filter->name() }}
                        </a>
                        <div class="dropdown-menu">
                            <div class="px-3 py-2 w-md">
                                {!! $filter->render() !!}
                                <div class="dropdown-divider"></div>
                                <button type="submit"
                                        id="button-filter"
                                        form="filters"
                                        class="btn btn-sm btn-default">
                                    {{ __('Apply') }}
                                </button>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        @foreach($filters as $filter)
            @if($filter->display && $filter->isApply())
                <a href="{{ $filter->resetLink() }}" class="badge badge-light">
                    {{$filter->value()}}
                </a>
            @endif
        @endforeach
    </div>
</div>