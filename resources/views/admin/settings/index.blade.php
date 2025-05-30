@extends('admin.layouts.app')

@section('title', 'Cài đặt hệ thống')

@section('breadcrumb')
<li class="breadcrumb-item active">Cài đặt</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Cài đặt hệ thống</h4>
                    <a href="{{ route('settings.create') }}" class="btn btn-primary">
                        <i class="mdi mdi-plus"></i> Thêm cài đặt
                    </a>
                </div>
                
                <form method="POST" action="{{ route('settings.store') }}" id="settingsForm">
                    @csrf
                    
                    @php
                        $groupedSettings = $settings->groupBy('group');
                    @endphp
                    
                    @foreach($groupedSettings as $group => $groupSettings)
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <button class="btn btn-link" type="button" data-bs-toggle="collapse" 
                                        data-bs-target="#collapse{{ Str::slug($group) }}" aria-expanded="true">
                                    {{ $group ?: 'Cài đặt chung' }}
                                    <i class="mdi mdi-chevron-down float-end"></i>
                                </button>
                            </h5>
                        </div>
                        <div id="collapse{{ Str::slug($group) }}" class="collapse show">
                            <div class="card-body">
                                <div class="row">
                                    @foreach($groupSettings as $setting)
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="setting_{{ $setting->id }}">
                                                {{ $setting->display_name }}
                                                @if($setting->details && isset(json_decode($setting->details, true)['required']) && json_decode($setting->details, true)['required'])
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </label>
                                            
                                            @switch($setting->type)
                                                @case('text')
                                                    <input type="text" class="form-control" 
                                                           id="setting_{{ $setting->id }}" 
                                                           name="settings[{{ $setting->key }}]" 
                                                           value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                                           placeholder="{{ $setting->display_name }}">
                                                    @break
                                                
                                                @case('textarea')
                                                    <textarea class="form-control" rows="3"
                                                              id="setting_{{ $setting->id }}" 
                                                              name="settings[{{ $setting->key }}]" 
                                                              placeholder="{{ $setting->display_name }}">{{ old('settings.' . $setting->key, $setting->value) }}</textarea>
                                                    @break
                                                
                                                @case('number')
                                                    <input type="number" class="form-control" 
                                                           id="setting_{{ $setting->id }}" 
                                                           name="settings[{{ $setting->key }}]" 
                                                           value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                                           placeholder="{{ $setting->display_name }}">
                                                    @break
                                                
                                                @case('email')
                                                    <input type="email" class="form-control" 
                                                           id="setting_{{ $setting->id }}" 
                                                           name="settings[{{ $setting->key }}]" 
                                                           value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                                           placeholder="{{ $setting->display_name }}">
                                                    @break
                                                
                                                @case('url')
                                                    <input type="url" class="form-control" 
                                                           id="setting_{{ $setting->id }}" 
                                                           name="settings[{{ $setting->key }}]" 
                                                           value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                                           placeholder="{{ $setting->display_name }}">
                                                    @break
                                                
                                                @case('checkbox')
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" 
                                                               id="setting_{{ $setting->id }}" 
                                                               name="settings[{{ $setting->key }}]" 
                                                               value="1"
                                                               {{ old('settings.' . $setting->key, $setting->value) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="setting_{{ $setting->id }}">
                                                            Bật/Tắt
                                                        </label>
                                                    </div>
                                                    @break
                                                
                                                @case('select')
                                                    @php
                                                        $options = [];
                                                        if ($setting->details) {
                                                            $details = json_decode($setting->details, true);
                                                            $options = $details['options'] ?? [];
                                                        }
                                                    @endphp
                                                    <select class="form-control" id="setting_{{ $setting->id }}" 
                                                            name="settings[{{ $setting->key }}]">
                                                        <option value="">Chọn...</option>
                                                        @foreach($options as $key => $value)
                                                            <option value="{{ $key }}" 
                                                                    {{ old('settings.' . $setting->key, $setting->value) == $key ? 'selected' : '' }}>
                                                                {{ $value }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @break
                                                
                                                @default
                                                    <input type="text" class="form-control" 
                                                           id="setting_{{ $setting->id }}" 
                                                           name="settings[{{ $setting->key }}]" 
                                                           value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                                           placeholder="{{ $setting->display_name }}">
                                            @endswitch
                                            
                                            @if($setting->details && isset(json_decode($setting->details, true)['description']))
                                                <small class="form-text text-muted">
                                                    {{ json_decode($setting->details, true)['description'] }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="mdi mdi-content-save"></i> Lưu cài đặt
                        </button>
                        <button type="button" class="btn btn-light" onclick="window.location.reload()">
                            <i class="mdi mdi-refresh"></i> Làm mới
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Quản lý cài đặt</h4>
                <div class="table-responsive">
                    <table class="table table-hover" id="settingsTable">
                        <thead>
                            <tr>
                                <th>Key</th>
                                <th>Tên hiển thị</th>
                                <th>Giá trị</th>
                                <th>Loại</th>
                                <th>Nhóm</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($settings as $setting)
                            <tr>
                                <td><code>{{ $setting->key }}</code></td>
                                <td>{{ $setting->display_name }}</td>
                                <td>
                                    @if($setting->type == 'checkbox')
                                        <span class="badge badge-{{ $setting->value ? 'success' : 'secondary' }}">
                                            {{ $setting->value ? 'Bật' : 'Tắt' }}
                                        </span>
                                    @else
                                        {{ Str::limit($setting->value, 50) }}
                                    @endif
                                </td>
                                <td><span class="badge badge-info">{{ $setting->type }}</span></td>
                                <td>{{ $setting->group ?: 'Chưa phân nhóm' }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('settings.edit', $setting->id) }}" class="btn btn-sm btn-warning">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
                                        <form action="{{ route('settings.destroy', $setting->id) }}" method="POST" class="d-inline" 
                                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa cài đặt này không?');">
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
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#settingsTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/vi.json'
        },
        pageLength: 25,
        order: [[4, 'asc'], [1, 'asc']] // Sort by group then by display name
    });
    
    // Auto-save form
    $('#settingsForm input, #settingsForm textarea, #settingsForm select').on('change', function() {
        $(this).addClass('border-warning');
    });
});
</script>
@endpush