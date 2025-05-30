@extends('admin.layouts.app')

@section('title', 'Chi tiết vai trò')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Vai trò</a></li>
<li class="breadcrumb-item active">Chi tiết</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Thông tin vai trò</h4>
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <td class="fw-bold" width="30%">ID:</td>
                            <td>{{ $role->id }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Tên vai trò:</td>
                            <td><span class="badge badge-primary">{{ $role->name }}</span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Tên hiển thị:</td>
                            <td>{{ $role->display_name ?? 'Chưa có' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Mô tả:</td>
                            <td>{{ $role->description ?? 'Chưa có mô tả' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Guard:</td>
                            <td><span class="badge badge-info">{{ $role->guard_name }}</span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Số quyền:</td>
                            <td><span class="badge badge-success">{{ $role->permissions->count() }}</span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Số người dùng:</td>
                            <td><span class="badge badge-warning">{{ $role->users->count() }}</span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Ngày tạo:</td>
                            <td>{{ $role->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Cập nhật cuối:</td>
                            <td>{{ $role->updated_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
                
                <div class="mt-3">
                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary btn-sm">
                        <i class="mdi mdi-pencil"></i> Chỉnh sửa
                    </a>
                    <a href="{{ route('roles.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="mdi mdi-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Quyền hạn của vai trò</h4>
                @if($role->permissions->count() > 0)
                    @php
                        $groupedPermissions = $role->permissions->groupBy(function($permission) {
                            return explode('_', $permission->name)[0];
                        });
                    @endphp
                    
                    @foreach($groupedPermissions as $group => $groupPermissions)
                    <div class="mb-3">
                        <h6 class="text-capitalize mb-2">{{ ucfirst($group) }}</h6>
                        <div class="d-flex flex-wrap">
                            @foreach($groupPermissions as $permission)
                            <span class="badge badge-outline-primary me-1 mb-1">{{ $permission->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted">Vai trò này chưa có quyền hạn nào.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Người dùng có vai trò này ({{ $role->users->count() }})</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Avatar</th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Trạng thái</th>
                                <th>Đăng nhập cuối</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($role->users as $user)
                            <tr>
                                <td>
                                    <img class="img-sm rounded-circle" 
                                         src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('admin/images/faces/face15.jpg') }}" 
                                         alt="avatar">
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->is_admin)
                                        <span class="badge badge-success">Admin</span>
                                    @else
                                        <span class="badge badge-secondary">User</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->last_login_at)
                                        {{ $user->last_login_at->diffForHumans() }}
                                    @else
                                        <span class="text-muted">Chưa đăng nhập</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-info">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Chưa có người dùng nào được gán vai trò này</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection