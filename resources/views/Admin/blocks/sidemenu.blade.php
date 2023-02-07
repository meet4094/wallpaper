<div class="main-sidebar main-sidebar-sticky side-menu">
    <div class=" sidemenu-logo">
        <a class="main-logo" href="index.html">
            <img src="" class="header-brand-img desktop-logo">
            <img src="" class="header-brand-img icon-logo">
            <img src="" class="header-brand-img desktop-logo theme-logo">
            <img src="" class="header-brand-img icon-logo theme-logo">
        </a>
    </div>
    <div class="main-sidebar-body">
        <ul class="nav">
            <li class="nav-label">Category</li>
            <li class="nav-item {{ @$title == 'category' ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/') }}"><i class="fe fe-box"></i><span class="sidemenu-label">Category</span></a>
            </li>
            <li class="nav-item {{ @$title == 'items' ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/category_items') }}"><i class="fe fe-box"></i><span class="sidemenu-label">Images</span></a>
            </li>
        </ul>
    </div>
</div>