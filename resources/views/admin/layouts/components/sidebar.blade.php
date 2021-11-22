<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard.index') }}"><img class="osahan-logo mr-2" src="{{ asset("images/".setting('site_logo')) }}" alt="logo" style="width: 200px;"></a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard.index') }}">
              <img class="osahan-logo mr-2" src="{{ asset("images/".setting('site_logo')) }}" alt="logo">
            </a>
        </div>

        <ul class="sidebar-menu">
            {!! $backendMenus !!}
        </ul>
    </aside>
</div>
