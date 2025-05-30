@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa vai trò')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Vai trò</a></li>
<li class="breadcrumb-item active">Chỉnh sửa</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Chỉnh sửa vai trò: {{ $role->name }}</h4>
                <form class="forms-sample" method="POST" action="{{ route('roles.update', $role->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Tên vai trò <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $role->name) }}" 
                                       placeholder="Ví dụ: editor, manager" required>
                                <small class="form-text text-muted">Tên vai trò không có dấu cách, chỉ chứa chữ cái, số và dấu gạch dưới</small>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="display_name">Tên hiển thị</label>
                                <input type="text" class="form-control @error('display_name') is-invalid @enderror" 
                                       id="display_name" name="display_name" value="{{ old('display_name', $role->display_name) }}" 
                                       placeholder="Ví dụ: Biên tập viên, Quản lý">
                                @error('display_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Mô tả</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3" 
                                  placeholder="Mô tả về vai trò này">{{ old('description', $role->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    @if($permissions->count() > 0)
                    <div class="form-group">
                        <label>Quyền hạn</label>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <button type="button" class="btn btn-sm btn-outline-primary" id="selectAll">Chọn tất cả</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="deselectAll">Bỏ chọn tất cả</button>
                                <span class="ms-3 text-muted">
                                    Đã chọn: <span id="selectedCount">{{ count($rolePermissions) }}</span>/{{ $permissions->count() }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="row">
                            @php
                                $groupedPermissions = $permissions->groupBy(function($permission) {
                                    return explode('_', $permission->name)[0];
                                });
                            @endphp
                            
                            @foreach($groupedPermissions as $group => $groupPermissions)
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card">
                                    <div class="card-header py-2">
                                        <h6 class="mb-0 text-capitalize">{{ ucfirst($group) }}</h6>
                                    </div>
                                    <div class="card-body py-2">
                                        @foreach($groupPermissions as $permission)
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input permission-checkbox" 
                                                   id="permission_{{ $permission->id }}" name="permissions[]" 
                                                   value="{{ $permission->id }}"
                                                   {{ in_array($permission->id, old('permissions', $rolePermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <button type="submit" class="btn btn-primary me-2">Cập nhật</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-light">Hủy</a>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Người dùng có vai trò này</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Ngày gán vai trò</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($role->users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->pivot->created_at ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-info">
                                        <i class="mdi mdi-eye"></i> Xem
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Chưa có người dùng nào được gán vai trò này</td>
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

@push('scripts')
<script>
$(document).ready(function() {
    // Count selected permissions
    function updateSelectedCount() {
        let count = $('.permission-checkbox:checked').length;
        $('#selectedCount').text(count);
    }
    
    // Select all permissions
    $('#selectAll').click(function() {
        $('.permission-checkbox').prop('checked', true);
        updateSelectedCount();
    });
    
    // Deselect all permissions
    $('#deselectAll').click(function() {
        $('.permission-checkbox').prop('checked', false);
        updateSelectedCount();
    });
    
    // Update count when checkbox changes
    $('.permission-checkbox').change(function() {
        updateSelectedCount();
    });
    
    // Initialize count
    updateSelectedCount();
});
</script>
@endpush