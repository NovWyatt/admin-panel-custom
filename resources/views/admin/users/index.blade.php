@extends('admin.layouts.app')

@section('title', 'Quản lý người dùng')

@section('breadcrumb')
<li class="breadcrumb-item active">Người dùng</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Danh sách người dùng</h4>
                    <a href="{{ route('users.create') }}" class="btn btn-primary">
                        <i class="mdi mdi-plus"></i> Thêm người dùng
                    </a>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover" id="usersTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Vai trò</th>
                                <th>Trạng thái</th>
                                <th>Ngày tạo</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- DataTables will populate this -->
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
    $('#usersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('users.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'roles', name: 'roles', orderable: false, searchable: false},
            {
                data: 'is_admin', 
                name: 'is_admin',
                render: function(data, type, row) {
                    return data ? '<span class="badge badge-success">Admin</span>' : '<span class="badge badge-secondary">User</span>';
                }
            },
            {
                data: 'created_at', 
                name: 'created_at',
                render: function(data, type, row) {
                    return new Date(data).toLocaleDateString('vi-VN');
                }
            },
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/vi.json'
        }
    });
});
</script>
@endpush