<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
      <img src="{{ asset('adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
              <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
              <a href="#" class="d-block">Alexander Pierce</a>
          </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
              <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                  <button class="btn btn-sidebar">
                      <i class="fas fa-search fa-fw"></i>
                  </button>
              </div>
          </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Danh mục sản phẩm -->
              <li class="nav-item">
                  <a href="{{ route('categories.index') }}" class="nav-link">
                      <i class="nav-icon fas fa-list"></i>
                      <p>
                          Danh mục sản phẩm
                          <span class="right badge badge-danger">New</span>
                      </p>
                  </a>
              </li>
              
              <!-- Menu -->
              <li class="nav-item">
                  <a href="{{ route('menus.index') }}" class="nav-link">
                      <i class="nav-icon fas fa-th"></i>
                      <p>
                          Menu
                      </p>
                  </a>
              </li>

              <!-- Sản phẩm -->
              <li class="nav-item">
                  <a href="{{ route('products.index') }}" class="nav-link">
                      <i class="nav-icon fas fa-box"></i>
                      <p>
                          Sản phẩm
                      </p>
                  </a>
              </li>

              <!-- Slider -->
              <li class="nav-item">
                  <a href="{{ route('sliders.index') }}" class="nav-link">
                      <i class="nav-icon fas fa-sliders-h"></i>
                      <p>
                          Slider
                          <span class="right badge badge-danger">Hot</span>
                      </p>
                  </a>
              </li>

              <!-- Settings -->
              <li class="nav-item">
                  <a href="{{ route('settings.index') }}" class="nav-link">
                      <i class="nav-icon fas fa-cogs"></i>
                      <p>
                          Settings
                          <span class="right badge badge-danger">Hot</span>
                      </p>
                  </a>
              </li>

              <!-- Users -->
              <li class="nav-item">
                  <a href="{{ route('users.index') }}" class="nav-link">
                      <i class="nav-icon fas fa-users"></i>
                      <p>
                          Danh sách User
                          <span class="right badge badge-danger">Hot</span>
                      </p>
                  </a>
              </li>

              <!-- Roles -->
              <li class="nav-item">
                  <a href="{{ route('roles.index') }}" class="nav-link">
                      <i class="nav-icon fas fa-user-tag"></i>
                      <p>
                          Vai trò
                          <span class="right badge badge-danger">Hello</span>
                      </p>
                  </a>
              </li>

              <!-- Permissions -->
              <li class="nav-item">
                  <a href="{{ route('permissions.create') }}" class="nav-link">
                      <i class="nav-icon fas fa-lock"></i>
                      <p>
                          Permission
                          <span class="right badge badge-danger">Hello</span>
                      </p>
                  </a>
              </li>

              <!-- Cart Management -->
              <li class="nav-item">
                  <a href="{{ route('carts.index') }}" class="nav-link">
                      <i class="nav-icon fas fa-shopping-cart"></i>
                      <p>
                          Quản lý giỏ hàng
                      </p>
                  </a>
              </li>
          </ul>
      </nav>
      <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
