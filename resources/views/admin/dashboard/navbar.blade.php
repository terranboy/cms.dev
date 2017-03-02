<nav class="navbar navbar-default navbar-fixed-top navbar-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <div class="hamburger @if ($menuExpanded) is-active @endif ">
                <span class="hamburger-inner"></span>
            </div>

            <ol class="breadcrumb">
                @if(count(Request::segments()) == 1)
                    <li class="active"><i class="voyager-boat"></i> Dashboard</li>
                @else
                    <li class="active">
                        <a href="/admin"><i class="voyager-boat"></i> Dashboard</a>
                    </li>
                @endif
                <?php $breadcrumb_url = ''; ?>
                @for($i = 1; $i <= count(Request::segments()); $i++)
                    <?php $breadcrumb_url .= '/' . Request::segment($i); ?>
                    @if(Request::segment($i) != ltrim('/admin', '/') && !is_numeric(Request::segment($i)))

                        @if($i < count(Request::segments()) & $i > 0)
                            <li class="active"><a
                                        href="{{ $breadcrumb_url }}">{{ ucwords(str_replace('-', ' ', str_replace('_', ' ', Request::segment($i)))) }}</a>
                            </li>
                        @else
                            <li>{{ ucwords(str_replace('-', ' ', str_replace('_', ' ', Request::segment($i)))) }}</li>
                        @endif

                    @endif
                @endfor
            </ol>


            <button type="button" class="navbar-right-expand-toggle pull-right visible-xs">
                <i class="voyager-list icon"></i>
            </button>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <button type="button" class="navbar-right-expand-toggle pull-right visible-xs">
                <i class="voyager-x icon"></i>
            </button>
            <li class="dropdown profile">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                   aria-expanded="false"><img src="{!! asset('images/avatar-default.png') !!}" class="profile-img"> <span
                            class="caret"></span></a>
                <ul class="dropdown-menu dropdown-menu-animated">
                    <li class="profile-img">
                        <img src="{!! asset('images/avatar-default.png') !!}" class="profile-img">
                        <div class="profile-body">
                            <h5>{{ Auth::user()->name }}</h5>
                            <h6>{{ Auth::user()->email }}</h6>
                        </div>
                    </li>
                    <li class="divider"></li>

                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                            <i class="voyager-power"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
