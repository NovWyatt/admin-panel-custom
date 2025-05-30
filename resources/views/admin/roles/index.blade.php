@extends('admin.layouts.app')

@section('title', 'Quản lý vai trò')

@section('breadcrumb')
<li class="breadcrumb-item active">Vai trò</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Danh sách vai trò</h4>
                    <a href="{{ route('roles.create') }}" class="btn btn-primary">
                        <i class="mdi mdi-plus"></i> Thêm vai trò
                    </a>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover" id="rolesTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên vai trò</th>
                                <th>Tên hiển thị</th>
                                <th>Số quyền</th>
                                <th>Số người dùng</th>
                                <th>Ngày tạo</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td><span class="badge badge-primary">{{ $role->name }}</span></td>
                                <td>{{ $role->display_name ?? $role->name }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $role->permissions->count() }} quyền</span>
                                </td>
                                <td>
                                    <span class="badge badge-success">{{ $role->users->count() }} người</span>
                                </td>
                                <td>{{ $role->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('roles.show', $role->id) }}" class="btn btn-sm btn-info">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-warning">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline" 
                                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa vai trò này không?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($roles->hasPages())
                <div class="mt-3">
                    {{ $roles->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#rolesTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/vi.json'
        },
        pageLength: 25,
        order: [[0, 'desc']]
    });
});
</script>
@endpush