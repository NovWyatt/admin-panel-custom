@extends('admin.layouts.app')

@section('title', 'Chi tiết người dùng')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('users.index') }}">Người dùng</a></li>
<li class="breadcrumb-item active">Chi tiết</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column align-items-center text-center">
                    <img class="rounded-circle" width="150" height="150" 
                         src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('admin/images/faces/face15.jpg') }}" 
                         alt="avatar">
                    <div class="mt-3">
                        <h4>{{ $user->name }}</h4>
                        <p class="text-secondary mb-1">{{ $user->email }}</p>
                        <p class="text-muted font-size-sm">
                            @if($user->is_admin)
                                <span class="badge badge-success">Quản trị viên</span>
                            @else
                                <span class="badge badge-secondary">Người dùng</span>
                            @endif
                        </p>
                        <div class="mt-2">
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">Chỉnh sửa</a>
                            <a href="{{ route('users.index') }}" class="btn btn-outline-primary btn-sm">Quay lại</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Thông tin chi tiết</h4>
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <td class="fw-bold" width="30%">ID:</td>
                            <td>{{ $user->id }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Tên đầy đủ:</td>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Email:</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Số điện thoại:</td>
                            <td>{{ $user->phone ?: 'Chưa cập nhật' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Địa chỉ:</td>
                            <td>{{ $user->address ?: 'Chưa cập nhật' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Quyền quản trị:</td>
                            <td>
                                @if($user->is_admin)
                                    <span class="badge badge-success">Có</span>
                                @else
                                    <span class="badge badge-secondary">Không</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Vai trò:</td>
                            <td>
                                @forelse($user->roles as $role)
                                    <span class="badge badge-primary me-1">{{ $role->name }}</span>
                                @empty
                                    <span class="text-muted">Chưa có vai trò nào</span>
                                @endforelse
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Ngày tạo:</td>
                            <td>{{ $user->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Cập nhật lần cuối:</td>
                            <td>{{ $user->updated_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        @if($user->last_login_at)
                        <tr>
                            <td class="fw-bold">Đăng nhập lần cuối:</td>
                            <td>{{ $user->last_login_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        @endif
                        @if($user->last_login_ip)
                        <tr>
                            <td class="fw-bold">IP đăng nhập cuối:</td>
                            <td>{{ $user->last_login_ip }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Lịch sử hoạt động</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Hành động</th>
                                <th>Mô tả</th>
                                <th>IP</th>
                                <th>Thời gian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activities as $activity)
                            <tr>
                                <td>
                                    <span class="badge badge-{{ $activity->action == 'created' ? 'success' : ($activity->action == 'updated' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($activity->action) }}
                                    </span>
                                </td>
                                <td>{{ $activity->description }}</td>
                                <td>{{ $activity->ip_address ?: '-' }}</td>
                                <td>{{ $activity->created_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Chưa có hoạt động nào được ghi lại</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($activities instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="mt-3">
                    {{ $activities->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection