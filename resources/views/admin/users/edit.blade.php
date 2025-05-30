@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa người dùng')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('users.index') }}">Người dùng</a></li>
<li class="breadcrumb-item active">Chỉnh sửa</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Chỉnh sửa người dùng: {{ $user->name }}</h4>
                <form class="forms-sample" method="POST" action="{{ route('users.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="name">Tên đầy đủ</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $user->name) }}" placeholder="Nhập tên đầy đủ" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Nhập địa chỉ email" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Mật khẩu mới (để trống nếu không đổi)</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" placeholder="Nhập mật khẩu mới">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirmation">Xác nhận mật khẩu mới</label>
                        <input type="password" class="form-control" id="password_confirmation" 
                               name="password_confirmation" placeholder="Nhập lại mật khẩu mới">
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Số điện thoại</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Nhập số điện thoại">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="address">Địa chỉ</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="3" placeholder="Nhập địa chỉ">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_admin" name="is_admin" value="1" 
                               {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_admin">
                            Quyền quản trị viên
                        </label>
                    </div>
                    
                    @if($roles->count() > 0)
                    <div class="form-group">
                        <label>Vai trò</label>
                        <div class="row">
                            @foreach($roles as $role)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" 
                                           id="role_{{ $role->id }}" name="roles[]" value="{{ $role->id }}"
                                           {{ in_array($role->id, old('roles', $userRoles)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="role_{{ $role->id }}">
                                        {{ $role->name }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <button type="submit" class="btn btn-primary me-2">Cập nhật</button>
                    <a href="{{ route('users.index') }}" class="btn btn-light">Hủy</a>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Thông tin bổ sung</h4>
                <div class="profile-info">
                    <div class="d-flex align-items-center mb-3">
                        <img class="img-sm rounded-circle me-2" 
                             src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('admin/images/faces/face15.jpg') }}" 
                             alt="profile">
                        <h6 class="mb-0">{{ $user->name }}</h6>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold">ID:</td>
                                <td>{{ $user->id }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Ngày tạo:</td>
                                <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Cập nhật lần cuối:</td>
                                <td>{{ $user->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @if($user->last_login_at)
                            <tr>
                                <td class="fw-bold">Đăng nhập lần cuối:</td>
                                <td>{{ $user->last_login_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @endif
                            @if($user->last_login_ip)
                            <tr>
                                <td class="fw-bold">IP lần cuối:</td>
                                <td>{{ $user->last_login_ip }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
                
                <div class="mt-3">
                    <h6>Vai trò hiện tại</h6>
                    @forelse($user->roles as $role)
                        <span class="badge badge-primary me-1">{{ $role->name }}</span>
                    @empty
                        <span class="text-muted">Chưa có vai trò nào</span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection