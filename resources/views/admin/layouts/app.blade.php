<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'Admin Panel') }}</title>
    
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('admin/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendors/font-awesome/css/font-awesome.min.css') }}">
    <!-- endinject -->
    
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('admin/vendors/jvectormap/jquery-jvectormap.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendors/flag-icon-css/css/flag-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendors/owl-carousel-2/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendors/owl-carousel-2/owl.theme.default.min.css') }}">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
    <!-- End layout styles -->
    
    <link rel="shortcut icon" href="{{ asset('admin/images/favicon.png') }}" />
    
    @stack('styles')
</head>
<body>
    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
                <a class="sidebar-brand brand-logo" href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('admin/images/logo.svg') }}" alt="logo" />
                </a>
                <a class="sidebar-brand brand-logo-mini" href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('admin/images/logo-mini.svg') }}" alt="logo" />
                </a>
            </div>
            <ul class="nav">
                <!-- Profile Section -->
                <li class="nav-item profile">
                    <div class="profile-desc">
                        <div class="profile-pic">
                            <div class="count-indicator">
                                <img class="img-xs rounded-circle" 
                                     src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('admin/images/faces/face15.jpg') }}" 
                                     alt="">
                                <span class="count bg-success"></span>
                            </div>
                            <div class="profile-name">
                                <h5 class="mb-0 font-weight-normal">{{ Auth::user()->name }}</h5>
                                <span>{{ Auth::user()->roles->first()?->name ?? 'Admin' }}</span>
                            </div>
                        </div>
                        <a href="#" id="profile-dropdown" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
                            <a href="{{ route('users.edit', Auth::id()) }}" class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-dark rounded-circle">
                                        <i class="mdi mdi-cog text-primary"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <p class="preview-subject ellipsis mb-1 text-small">Cài đặt tài khoản</p>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-dark rounded-circle">
                                        <i class="mdi mdi-onepassword text-info"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <p class="preview-subject ellipsis mb-1 text-small">Đổi mật khẩu</p>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" 
                                   onclick="event.preventDefault(); this.closest('form').submit();"
                                   class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-logout text-danger"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject ellipsis mb-1 text-small">Đăng xuất</p>
                                    </div>
                                </a>
                            </form>
                        </div>
                    </div>
                </li>
                
                <!-- Navigation -->
                <li class="nav-item nav-category">
                    <span class="nav-link">Điều hướng</span>
                </li>
                
                <!-- Dashboard -->
                <li class="nav-item menu-items">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                       href="{{ route('admin.dashboard') }}">
                        <span class="menu-icon">
                            <i class="mdi mdi-speedometer"></i>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                
                <!-- User Management -->
                <li class="nav-item menu-items">
                    <a class="nav-link {{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('permissions.*') ? 'collapsed' : '' }}" 
                       data-bs-toggle="collapse" href="#user-management" 
                       aria-expanded="{{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('permissions.*') ? 'true' : 'false' }}" 
                       aria-controls="user-management">
                        <span class="menu-icon">
                            <i class="mdi mdi-account-multiple"></i>
                        </span>
                        <span class="menu-title">Quản lý người dùng</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('permissions.*') ? 'show' : '' }}" 
                         id="user-management">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> 
                                <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" 
                                   href="{{ route('users.index') }}">Người dùng</a>
                            </li>
                            <li class="nav-item"> 
                                <a class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}" 
                                   href="{{ route('roles.index') }}">Vai trò</a>
                            </li>
                            <li class="nav-item"> 
                                <a class="nav-link {{ request()->routeIs('permissions.*') ? 'active' : '' }}" 
                                   href="{{ route('permissions.index') }}">Quyền hạn</a>
                            </li>
                        </ul>
                    </div>
                </li>
                
                <!-- Content Management -->
                <li class="nav-item menu-items">
                    <a class="nav-link {{ request()->routeIs('menus.*') || request()->routeIs('menu-items.*') ? 'collapsed' : '' }}" 
                       data-bs-toggle="collapse" href="#content-management" 
                       aria-expanded="{{ request()->routeIs('menus.*') || request()->routeIs('menu-items.*') ? 'true' : 'false' }}" 
                       aria-controls="content-management">
                        <span class="menu-icon">
                            <i class="mdi mdi-file-document"></i>
                        </span>
                        <span class="menu-title">Quản lý nội dung</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('menus.*') || request()->routeIs('menu-items.*') ? 'show' : '' }}" 
                         id="content-management">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> 
                                <a class="nav-link {{ request()->routeIs('menus.*') ? 'active' : '' }}" 
                                   href="{{ route('menus.index') }}">Menu</a>
                            </li>
                            <li class="nav-item"> 
                                <a class="nav-link {{ request()->routeIs('menu-items.*') ? 'active' : '' }}" 
                                   href="{{ route('menu-items.index') }}">Menu Items</a>
                            </li>
                        </ul>
                    </div>
                </li>
                
                <!-- System -->
                <li class="nav-item menu-items">
                    <a class="nav-link {{ request()->routeIs('data-types.*') ? 'active' : '' }}" 
                       href="{{ route('data-types.index') }}">
                        <span class="menu-icon">
                            <i class="mdi mdi-database"></i>
                        </span>
                        <span class="menu-title">Loại dữ liệu</span>
                    </a>
                </li>
                
                <!-- Settings -->
                <li class="nav-item menu-items">
                    <a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}" 
                       href="{{ route('settings.index') }}">
                        <span class="menu-icon">
                            <i class="mdi mdi-cog"></i>
                        </span>
                        <span class="menu-title">Cài đặt</span>
                    </a>
                </li>
                
                <!-- Tools -->
                <li class="nav-item menu-items">
                    <a class="nav-link {{ request()->routeIs('activity-logs.*') || request()->routeIs('backups.*') ? 'collapsed' : '' }}" 
                       data-bs-toggle="collapse" href="#tools" 
                       aria-expanded="{{ request()->routeIs('activity-logs.*') || request()->routeIs('backups.*') ? 'true' : 'false' }}" 
                       aria-controls="tools">
                        <span class="menu-icon">
                            <i class="mdi mdi-tools"></i>
                        </span>
                        <span class="menu-title">Công cụ</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('activity-logs.*') || request()->routeIs('backups.*') ? 'show' : '' }}" 
                         id="tools">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> 
                                <a class="nav-link {{ request()->routeIs('activity-logs.*') ? 'active' : '' }}" 
                                   href="{{ route('activity-logs.index') }}">Nhật ký hoạt động</a>
                            </li>
                            <li class="nav-item"> 
                                <a class="nav-link {{ request()->routeIs('backups.*') ? 'active' : '' }}" 
                                   href="{{ route('backups.index') }}">Sao lưu</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>
        
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_navbar.html -->
            <nav class="navbar p-0 fixed-top d-flex flex-row">
                <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
                    <a class="navbar-brand brand-logo-mini" href="{{ route('admin.dashboard') }}">
                        <img src="{{ asset('admin/images/logo-mini.svg') }}" alt="logo" />
                    </a>
                </div>
                <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                        <span class="mdi mdi-menu"></span>
                    </button>
                    <ul class="navbar-nav w-100">
                        <li class="nav-item w-100">
                            <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search">
                                <input type="text" class="form-control" placeholder="Tìm kiếm...">
                            </form>
                        </li>
                    </ul>
                    <ul class="navbar-nav navbar-nav-right">
                        <!-- Create New Dropdown -->
                        <li class="nav-item dropdown d-none d-lg-block">
                            <a class="nav-link btn btn-success create-new-button" id="createbuttonDropdown" 
                               data-bs-toggle="dropdown" aria-expanded="false" href="#">+ Tạo mới</a>
                            <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list" 
                                 aria-labelledby="createbuttonDropdown">
                                <h6 class="p-3 mb-0">Tạo mới</h6>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item" href="{{ route('users.create') }}">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-account text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject ellipsis mb-1">Người dùng</p>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item" href="{{ route('roles.create') }}">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-security text-info"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject ellipsis mb-1">Vai trò</p>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item" href="{{ route('menus.create') }}">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-menu text-danger"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject ellipsis mb-1">Menu</p>
                                    </div>
                                </a>
                            </div>
                        </li>
                        
                        <!-- Settings -->
                        <li class="nav-item nav-settings d-none d-lg-block">
                            <a class="nav-link" href="{{ route('settings.index') }}">
                                <i class="mdi mdi-view-grid"></i>
                            </a>
                        </li>
                        
                        <!-- Notifications -->
                        <li class="nav-item dropdown border-left">
                            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" 
                               href="#" data-bs-toggle="dropdown">
                                <i class="mdi mdi-bell"></i>
                                <span class="count bg-danger"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list" 
                                 aria-labelledby="notificationDropdown">
                                <h6 class="p-3 mb-0">Thông báo</h6>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-calendar text-success"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Sự kiện hôm nay</p>
                                        <p class="text-muted ellipsis mb-0">Nhắc nhở về sự kiện hôm nay</p>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <p class="p-3 mb-0 text-center">Xem tất cả thông báo</p>
                            </div>
                        </li>
                        
                        <!-- Profile -->
                        <li class="nav-item dropdown">
                            <a class="nav-link" id="profileDropdown" href="#" data-bs-toggle="dropdown">
                                <div class="navbar-profile">
                                    <img class="img-xs rounded-circle" 
                                         src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('admin/images/faces/face15.jpg') }}" 
                                         alt="">
                                    <p class="mb-0 d-none d-sm-block navbar-profile-name">{{ Auth::user()->name }}</p>
                                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list" 
                                 aria-labelledby="profileDropdown">
                                <h6 class="p-3 mb-0">Hồ sơ</h6>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item" href="{{ route('users.edit', Auth::id()) }}">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-cog text-success"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Cài đặt</p>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="dropdown-item preview-item" href="{{ route('logout') }}" 
                                       onclick="event.preventDefault(); this.closest('form').submit();">
                                        <div class="preview-thumbnail">
                                            <div class="preview-icon bg-dark rounded-circle">
                                                <i class="mdi mdi-logout text-danger"></i>
                                            </div>
                                        </div>
                                        <div class="preview-item-content">
                                            <p class="preview-subject mb-1">Đăng xuất</p>
                                        </div>
                                    </a>
                                </form>
                                <div class="dropdown-divider"></div>
                                <p class="p-3 mb-0 text-center">Cài đặt nâng cao</p>
                            </div>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" 
                            type="button" data-toggle="offcanvas">
                        <span class="mdi mdi-format-line-spacing"></span>
                    </button>
                </div>
            </nav>
            
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <!-- Breadcrumb -->
                    @if(!request()->routeIs('admin.dashboard'))
                    <div class="row">
                        <div class="col-12">
                            <div class="page-header">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                        @yield('breadcrumb')
                                    </ol>
                                </nav>
                                <h3 class="page-title">@yield('title', 'Dashboard')</h3>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Success/Error Messages -->
                    @if(session('success'))
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @if ($errors->any())
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Main Content -->
                    @yield('content')
                </div>
                <!-- content-wrapper ends -->
                
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
                            Copyright © {{ date('Y') }} <a href="#" target="_blank">Wyatt</a>. 
                            All rights reserved.
                        </span>
                        <span class="text-muted float-none float-sm-end d-block mt-1 mt-sm-0 text-center">
                            Hand-crafted & made with Wyatt</i>
                        </span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    
    <!-- plugins:js -->
    <script src="{{ asset('admin/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    
    <!-- Plugin js for this page -->
    <script src="{{ asset('admin/vendors/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('admin/vendors/progressbar.js/progressbar.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/jvectormap/jquery-jvectormap.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('admin/vendors/owl-carousel-2/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('admin/js/jquery.cookie.js') }}" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <!-- inject:js -->
    <script src="{{ asset('admin/js/off-canvas.js') }}"></script>
    <script src="{{ asset('admin/js/misc.js') }}"></script>
    <script src="{{ asset('admin/js/settings.js') }}"></script>
    <script src="{{ asset('admin/js/todolist.js') }}"></script>
    <!-- endinject -->
    
    <!-- Setup Toastr -->
    <script>
        // Toastr configuration
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 5000
        };
        
        // Show toastr messages from session
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif
        
        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif
        
        @if(session('warning'))
            toastr.warning("{{ session('warning') }}");
        @endif
        
        @if(session('info'))
            toastr.info("{{ session('info') }}");
        @endif
    </script>
    
    @stack('scripts')
</body>
</html>