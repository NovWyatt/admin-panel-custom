@extends('admin.layouts.app')

@section('title', 'Thêm quyền hạn')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('permissions.index') }}">Quyền hạn</a></li>
<li class="breadcrumb-item active">Thêm mới</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Thêm quyền hạn mới</h4>
                <form class="forms-sample" method="POST" action="{{ route('permissions.store') }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Tên quyền <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" 
                                       placeholder="Ví dụ: browse_users, edit_posts" required>
                                <small class="form-text text-muted">Tên quyền không có dấu cách, sử dụng dấu gạch dưới</small>
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
                                       placeholder="Ví dụ: Xem danh sách người dùng">
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
                                  placeholder="Mô tả chi tiết về quyền hạn này">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary me-2">Lưu</button>
                    <a href="{{ route('permissions.index') }}" class="btn btn-light">Hủy</a>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Gợi ý tên quyền</h4>
                <div class="mb-3">
                    <h6>Người dùng (Users)</h6>
                    <div class="mb-2">
                        <button type="button" class="btn btn-sm btn-outline-primary me-1 mb-1 suggestion-btn" data-name="browse_users" data-display="Xem danh sách người dùng">browse_users</button>
                        <button type="button" class="btn btn-sm btn-outline-primary me-1 mb-1 suggestion-btn" data-name="read_users" data-display="Xem chi tiết người dùng">read_users</button>
                        <button type="button" class="btn btn-sm btn-outline-primary me-1 mb-1 suggestion-btn" data-name="edit_users" data-display="Chỉnh sửa người dùng">edit_users</button>
                        <button type="button" class="btn btn-sm btn-outline-primary me-1 mb-1 suggestion-btn" data-name="add_users" data-display="Thêm người dùng">add_users</button>
                        <button type="button" class="btn btn-sm btn-outline-primary me-1 mb-1 suggestion-btn" data-name="delete_users" data-display="Xóa người dùng">delete_users</button>
                    </div>
                </div>
                
                <div class="mb-3">
                    <h6>Vai trò (Roles)</h6>
                    <div class="mb-2">
                        <button type="button" class="btn btn-sm btn-outline-success me-1 mb-1 suggestion-btn" data-name="browse_roles" data-display="Xem danh sách vai trò">browse_roles</button>
                        <button type="button" class="btn btn-sm btn-outline-success me-1 mb-1 suggestion-btn" data-name="read_roles" data-display="Xem chi tiết vai trò">read_roles</button>
                        <button type="button" class="btn btn-sm btn-outline-success me-1 mb-1 suggestion-btn" data-name="edit_roles" data-display="Chỉnh sửa vai trò">edit_roles</button>
                        <button type="button" class="btn btn-sm btn-outline-success me-1 mb-1 suggestion-btn" data-name="add_roles" data-display="Thêm vai trò">add_roles</button>
                        <button type="button" class="btn btn-sm btn-outline-success me-1 mb-1 suggestion-btn" data-name="delete_roles" data-display="Xóa vai trò">delete_roles</button>
                    </div>
                </div>
                
                <div class="mb-3">
                    <h6>Cài đặt (Settings)</h6>
                    <div class="mb-2">
                        <button type="button" class="btn btn-sm btn-outline-warning me-1 mb-1 suggestion-btn" data-name="browse_settings" data-display="Xem cài đặt">browse_settings</button>
                        <button type="button" class="btn btn-sm btn-outline-warning me-1 mb-1 suggestion-btn" data-name="edit_settings" data-display="Chỉnh sửa cài đặt">edit_settings</button>
                    </div>
                </div>
                
                <div class="mb-3">
                    <h6>Hệ thống (System)</h6>
                    <div class="mb-2">
                        <button type="button" class="btn btn-sm btn-outline-danger me-1 mb-1 suggestion-btn" data-name="browse_admin" data-display="Truy cập admin panel">browse_admin</button>
                        <button type="button" class="btn btn-sm btn-outline-danger me-1 mb-1 suggestion-btn" data-name="view_logs" data-display="Xem log hệ thống">view_logs</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-generate display name from name
    $('#name').on('input', function() {
        let name = $(this).val();
        if (name && $('#display_name').val() === '') {
            let displayName = name.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
            $('#display_name').val(displayName);
        }
    });
    
    // Handle suggestion buttons
    $('.suggestion-btn').click(function() {
        let name = $(this).data('name');
        let display = $(this).data('display');
        
        $('#name').val(name);
        $('#display_name').val(display);
        
        // Highlight selected suggestion
        $('.suggestion-btn').removeClass('active');
        $(this).addClass('active');
    });
});
</script>
@endpush