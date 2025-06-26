<div class="side-nav">
    <div class="nav-brand mb-4">
        <i class="fas fa-user-shield me-2"></i>
        Admin Panel
    </div>
    <ul class="nav-links">
        <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}">
                <i class="fas fa-chart-line me-2"></i>
                Overview
            </a>
        </li>
        <li class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <a href="{{ route('admin.products.index') }}">
                <i class="fas fa-tshirt me-2"></i>
                Products
            </a>
        </li>
        <li class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <a href="{{ route('admin.categories.index') }}">
                <i class="fas fa-tags me-2"></i>
                Categories
            </a>
        </li>
        <li class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <a href="{{ route('admin.users.index') }}">
                <i class="fas fa-users me-2"></i>
                Users
            </a>
        </li>
        <li class="{{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
            <a href="{{ route('admin.reviews.index') }}">
                <i class="fas fa-comments me-2"></i>
                Reviews
            </a>
        </li>
    </ul>
</div> 