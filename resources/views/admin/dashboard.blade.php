@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">{{ $users_count ?? 0 }}</h3>
                                <p class="text-success ms-2 mb-0 font-weight-medium">+3.5%</p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-success">
                                <span class="mdi mdi-account-multiple icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Tổng người dùng</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">{{ \Spatie\Permission\Models\Role::count() }}</h3>
                                <p class="text-success ms-2 mb-0 font-weight-medium">+11%</p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-success">
                                <span class="mdi mdi-security icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Tổng vai trò</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">{{ \Spatie\Permission\Models\Permission::count() }}</h3>
                                <p class="text-danger ms-2 mb-0 font-weight-medium">-2.4%</p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-danger">
                                <span class="mdi mdi-key icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Tổng quyền hạn</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">{{ \App\Models\ActivityLog::count() }}</h3>
                                <p class="text-success ms-2 mb-0 font-weight-medium">+3.5%</p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-success">
                                <span class="mdi mdi-history icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Hoạt động gần đây</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-between">
                        <h4 class="card-title mb-1">Hoạt động gần đây</h4>
                        <p class="text-muted mb-1">Theo dõi hoạt động hệ thống</p>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="preview-list">
                                @forelse($activities ?? [] as $activity)
                                    <div class="preview-item border-bottom">
                                        <div class="preview-thumbnail">
                                            <div class="preview-icon bg-primary">
                                                <i class="mdi mdi-account"></i>
                                            </div>
                                        </div>
                                        <div class="preview-item-content d-sm-flex flex-grow">
                                            <div class="flex-grow">
                                                <h6 class="preview-subject">{{ $activity->description ?? 'Hoạt động mới' }}</h6>
                                                <p class="text-muted mb-0">{{ $activity->user->name ?? 'Hệ thống' }}</p>
                                            </div>
                                            <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                <p class="text-muted">{{ $activity->created_at->diffForHumans() }}</p>
                                                <p class="text-muted mb-0">{{ $activity->action }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="preview-item">
                                        <div class="preview-item-content">
                                            <p class="text-muted text-center">Chưa có hoạt động nào được ghi lại.</p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Thống kê nhanh</h4>
                    <div class="d-flex">
                        <div class="d-flex align-items-center me-4 text-muted font-weight-light">
                            <i class="mdi mdi-account-outline icon-sm me-2"></i>
                            <span>Người dùng online</span>
                        </div>
                        <div class="d-flex align-items-center text-muted font-weight-light">
                            <i class="mdi mdi-bookmark-outline icon-sm me-2"></i>
                            <span>Đang hoạt động:
                                {{ \App\Models\User::whereNotNull('last_login_at')->where('last_login_at', '>=', now()->subMinutes(15))->count() }}</span>
                        </div>
                    </div>
                    <div class="progress progress-md mt-4">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 75%" aria-valuenow="75"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6 ps-0">
                            <div id="order-chart"></div>
                            <div class="d-flex">
                                <div class="d-flex align-items-center me-3 text-muted font-weight-light">
                                    <i class="mdi mdi-reload icon-sm me-2"></i>
                                    <span>Tự động làm mới</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 pe-0">
                            <div id="sales-chart"></div>
                            <div class="d-flex">
                                <div class="d-flex align-items-center me-3 text-muted font-weight-light">
                                    <i class="mdi mdi-calendar icon-sm me-2"></i>
                                    <span>Hôm nay</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Quản lý nhanh</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Module</th>
                                    <th>Tổng số</th>
                                    <th>Hoạt động</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="mdi mdi-account-multiple me-2"></i>
                                            <span>Người dùng</span>
                                        </div>
                                    </td>
                                    <td>{{ $users_count ?? 0 }}</td>
                                    <td>{{ \App\Models\User::where('created_at', '>=', now()->subDays(7))->count() }} người
                                        mới tuần này</td>
                                    <td>
                                        <div class="badge badge-outline-success">Hoạt động</div>
                                    </td>
                                    <td>
                                        <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary">Quản lý</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="mdi mdi-security me-2"></i>
                                            <span>Vai trò</span>
                                        </div>
                                    </td>
                                    <td>{{ \Spatie\Permission\Models\Role::count() }}</td>
                                    <td>{{ \Spatie\Permission\Models\Role::where('created_at', '>=', now()->subDays(7))->count() }}
                                        vai trò mới</td>
                                    <td>
                                        <div class="badge badge-outline-success">Hoạt động</div>
                                    </td>
                                    <td>
                                        <a href="{{ route('roles.index') }}" class="btn btn-sm btn-primary">Quản lý</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="mdi mdi-key me-2"></i>
                                            <span>Quyền hạn</span>
                                        </div>
                                    </td>
                                    <td>{{ \Spatie\Permission\Models\Permission::count() }}</td>
                                    <td>Hệ thống ổn định</td>
                                    <td>
                                        <div class="badge badge-outline-success">Hoạt động</div>
                                    </td>
                                    <td>
                                        <a href="{{ route('permissions.index') }}" class="btn btn-sm btn-primary">Quản
                                            lý</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="mdi mdi-cogs me-2"></i>
                                            <span>Cài đặt</span>
                                        </div>
                                    </td>
                                    <td>{{ \App\Models\Setting::count() }}</td>
                                    <td>Cấu hình hệ thống</td>
                                    <td>
                                        <div class="badge badge-outline-warning">Cần kiểm tra</div>
                                    </td>
                                    <td>
                                        <a href="{{ route('settings.index') }}" class="btn btn-sm btn-primary">Quản lý</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // Auto refresh every 30 seconds
            setInterval(function () {
                // Refresh activity section
                location.reload();
            }, 300000); // 5 minutes

            console.log('Dashboard loaded successfully');
        });
    </script>
@endpush