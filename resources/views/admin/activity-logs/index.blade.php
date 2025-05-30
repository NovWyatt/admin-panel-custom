@extends('admin.layouts.app')

@section('title', 'Nhật ký hoạt động')

@section('breadcrumb')
<li class="breadcrumb-item active">Nhật ký hoạt động</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Nhật ký hoạt động hệ thống</h4>
                    <div>
                        <button class="btn btn-outline-danger btn-sm" onclick="confirmClearLogs()">
                            <i class="mdi mdi-delete-sweep"></i> Xóa tất cả log
                        </button>
                    </div>
                </div>
                
                <!-- Filter Form -->
                <div class="card mb-3">
                    <div class="card-body py-2">
                        <form method="GET" action="{{ route('activity-logs.index') }}" class="row g-3">
                            <div class="col-md-3">
                                <select name="user_id" class="form-control form-control-sm">
                                    <option value="">Tất cả người dùng</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="action" class="form-control form-control-sm">
                                    <option value="">Tất cả hành động</option>
                                    <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>Tạo mới</option>
                                    <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>Cập nhật</option>
                                    <option value="deleted" {{ request('action') == 'deleted' ? 'selected' : '' }}>Xóa</option>
                                    <option value="login" {{ request('action') == 'login' ? 'selected' : '' }}>Đăng nhập</option>
                                    <option value="logout" {{ request('action') == 'logout' ? 'selected' : '' }}>Đăng xuất</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="date_from" class="form-control form-control-sm" 
                                       value="{{ request('date_from') }}" placeholder="Từ ngày">
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="date_to" class="form-control form-control-sm" 
                                       value="{{ request('date_to') }}" placeholder="Đến ngày">
                            </div>
                            <div class="col-md-3">
                                <div class="btn-group w-100">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="mdi mdi-filter"></i> Lọc
                                    </button>
                                    <a href="{{ route('activity-logs.index') }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="mdi mdi-refresh"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="10%">Thời gian</th>
                                <th width="15%">Người dùng</th>
                                <th width="10%">Hành động</th>
                                <th width="35%">Mô tả</th>
                                <th width="15%">IP Address</th>
                                <th width="15%">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activities as $activity)
                            <tr>
                                <td>
                                    <small>{{ $activity->created_at->format('d/m/Y H:i:s') }}</small><br>
                                    <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                </td>
                                <td>
                                    @if($activity->user)
                                        <div class="d-flex align-items-center">
                                            <img class="img-xs rounded-circle me-2" 
                                                 src="{{ $activity->user->avatar ? asset('storage/' . $activity->user->avatar) : asset('admin/images/faces/face15.jpg') }}" 
                                                 alt="avatar">
                                            <div>
                                                <div class="font-weight-bold">{{ $activity->user->name }}</div>
                                                <small class="text-muted">{{ $activity->user->email }}</small>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">Hệ thống</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $badgeClass = match($activity->action) {
                                            'created' => 'success',
                                            'updated' => 'warning',
                                            'deleted' => 'danger',
                                            'login' => 'info',
                                            'logout' => 'secondary',
                                            default => 'primary'
                                        };
                                    @endphp
                                    <span class="badge badge-{{ $badgeClass }}">{{ ucfirst($activity->action) }}</span>
                                </td>
                                <td>
                                    <div>{{ $activity->description }}</div>
                                    @if($activity->model_type && $activity->model_id)
                                        <small class="text-muted">
                                            {{ class_basename($activity->model_type) }} ID: {{ $activity->model_id }}
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ $activity->ip_address ?: '-' }}</div>
                                    @if($activity->user_agent)
                                        <small class="text-muted" title="{{ $activity->user_agent }}">
                                            {{ Str::limit($activity->user_agent, 30) }}
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('activity-logs.show', $activity->id) }}" class="btn btn-sm btn-info">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                        <form action="{{ route('activity-logs.destroy', $activity->id) }}" method="POST" class="d-inline" 
                                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa log này không?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="mdi mdi-information-outline me-2"></i>
                                    Không có nhật ký hoạt động nào được tìm thấy
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($activities->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Hiển thị {{ $activities->firstItem() }} - {{ $activities->lastItem() }} 
                        trong tổng số {{ $activities->total() }} kết quả
                    </div>
                    {{ $activities->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row">
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                            <h3 class="mb-0">{{ $todayActivities }}</h3>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="icon icon-box-success">
                            <span class="mdi mdi-calendar-today icon-item"></span>
                        </div>
                    </div>
                </div>
                <h6 class="text-muted font-weight-normal">Hoạt động hôm nay</h6>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                            <h3 class="mb-0">{{ $weekActivities }}</h3>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="icon icon-box-warning">
                            <span class="mdi mdi-calendar-week icon-item"></span>
                        </div>
                    </div>
                </div>
                <h6 class="text-muted font-weight-normal">Hoạt động tuần này</h6>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                            <h3 class="mb-0">{{ $activeUsers }}</h3>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="icon icon-box-info">
                            <span class="mdi mdi-account-multiple icon-item"></span>
                        </div>
                    </div>
                </div>
                <h6 class="text-muted font-weight-normal">Người dùng hoạt động</h6>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                            <h3 class="mb-0">{{ $totalActivities }}</h3>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="icon icon-box-danger">
                            <span class="mdi mdi-history icon-item"></span>
                        </div>
                    </div>
                </div>
                <h6 class="text-muted font-weight-normal">Tổng số hoạt động</h6>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmClearLogs() {
    if (confirm('Bạn có chắc chắn muốn xóa tất cả nhật ký hoạt động không? Hành động này không thể hoàn tác.')) {
        // Create form to delete all logs
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("activity-logs.index") }}/clear-all';
        
        let csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        let methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);
        
        document.body.appendChild(form);
        form.submit();
    }
}

$(document).ready(function() {
    // Auto-refresh every 30 seconds
    setInterval(function() {
        if (!document.hidden) {
            window.location.reload();
        }
    }, 30000);
});
</script>
@endpush