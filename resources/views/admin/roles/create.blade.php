@extends('admin.layouts.app')

@section('title', 'Thêm vai trò')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Vai trò</a></li>
<li class="breadcrumb-item active">Thêm mới</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Thêm vai trò mới</h4>
                <form class="forms-sample" method="POST" action="{{ route('roles.store') }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Tên vai trò <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" 
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
                                       id="display_name" name="display_name" value="{{ old('display_name') }}" 
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
                                  placeholder="Mô tả về vai trò này">{{ old('description') }}</textarea>
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
                                                   {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
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
                    
                    <button type="submit" class="btn btn-primary me-2">Lưu</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-light">Hủy</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Select all permissions
    $('#selectAll').click(function() {
        $('.permission-checkbox').prop('checked', true);
    });
    
    // Deselect all permissions
    $('#deselectAll').click(function() {
        $('.permission-checkbox').prop('checked', false);
    });
    
    // Auto-generate display name from name
    $('#name').on('input', function() {
        let name = $(this).val();
        let displayName = name.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
        if ($('#display_name').val() === '') {
            $('#display_name').val(displayName);
        }
    });
});
</script>
@endpush