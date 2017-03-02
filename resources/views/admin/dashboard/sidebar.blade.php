<div class="side-menu sidebar-inverse">
    <nav class="navbar navbar-default" role="navigation">
        <div class="side-menu-container">
            <div class="navbar-header">
                <a class="navbar-brand" href="/admin">
                    <div class="logo-icon-container">
                        <img src="{!! asset('images/logo-icon-light.png') !!}" alt="Logo Icon">
                    </div>
                    <div class="title">Admin Panel</div>
                </a>
                <button type="button" class="navbar-expand-toggle pull-right visible-xs">
                    <i class="voyager-x icon"></i>
                </button>
            </div><!-- .navbar-header -->

            <div class="panel widget center bgimage"
                 style="background-image:url( {!! asset('images/bg.jpg') !!});">
                <div class="dimmer"></div>
                <div class="panel-content">
                    <img src="{!! asset('images/avatar-default.png') !!}" class="avatar" alt="{{ Auth::user()->name }} avatar">
                    <h4>{{ ucwords(Auth::user()->name) }}</h4>
                    <p>{{ Auth::user()->email }}</p>

                    <a href="" class="btn btn-primary">Profile</a>
                    <div style="clear:both"></div>
                </div>
            </div>

        </div>

        <ul class="nav navbar-nav">
            <li class="{{ Request::is('admin') ? 'active' : '' }}">
                <a href="/admin" target="_self">
                    <span class="icon voyager-boat"></span><span class="title">Dashboard</span>
                </a>
            </li>
            <li class="{{ Request::is('admin/categories*') ? 'active' : '' }}">
                <a href="/admin/categories" target="_self">
                    <span class="icon voyager-categories"></span><span class="title">Categories</span>
                </a>
            </li>
            <li class="{{ Request::is('admin/products*') ? 'active' : '' }}">
                <a href="/admin/products" target="_self">
                    <span class="icon voyager-images"></span><span class="title">Products</span>
                </a>
            </li>
            <li class="{{ Request::is('admin/articles*') ? 'active' : '' }}">
                <a href="/admin/articles" target="_self">
                    <span class="icon voyager-news"></span><span class="title">Articles</span>
                </a>
            </li>
            <li class="{{ Request::is('admin/page*') ? 'active' : '' }}">
                <a href="/admin/pages" target="_self">
                    <span class="icon voyager-file-text"></span><span class="title">Pages</span>
                </a>
            </li>
            <li class="{{ Request::is('admin/settings') ? 'active' : '' }}">
                <a href="/admin/settings" target="_self">
                    <span class="icon voyager-settings"></span><span class="title">Settings</span>
                </a>
            </li>
        </ul>

    </nav>
</div>
