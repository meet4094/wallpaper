<div class="main-header side-header sticky">
    <div class="container-fluid">
        <div class="main-header-left">
            <a class="main-logo d-lg-none" href="index.html">
                <img src="" class="header-brand-img desktop-logo">
            </a>
            <a class="main-header-menu-icon" href="" id="mainSidebarToggle"><span></span></a>
        </div>
        <div class="main-header-right">
            <div class="dropdown main-profile-menu">
                <a class="main-img-user" href=""><img alt="avatar" src="{{ asset ('assets/img/brand/users.png') }}"></a>
                <div class="dropdown-menu">
                    <div class="header-navheading">
                        <h6 class="main-notification-title text-capitalize">{{ Auth::User()->email }}</h6>
                    </div>
                    <a class="dropdown-item" href="{{ url('logout') }}">
                        <i class="fe fe-power"></i> Log Out
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>