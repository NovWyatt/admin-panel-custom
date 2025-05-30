@extends('admin.layouts.app')

@section('title', 'Quản lý Menu')

@section('breadcrumb')
<li class="breadcrumb-item active">Menu</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Danh sách Menu</h4>
                    <a href="{{ route('menus.create') }}" class="btn btn-primary">
                        <i class="mdi mdi-plus"></i> Thêm Menu
                    </a>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên Menu</th>
                                <th>Mô tả</th>
                                <th>Số lượng item</th>
                                <th>Ngày tạo</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($menus as $menu)
                            <tr>
                                <td>{{ $menu->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="mdi mdi-menu me-2 text-primary"></i>
                                        <strong>{{ $menu->name }}</strong>
                                    </div>
                                </td>
                                <td>{{ $menu->description ?: '-' }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $menu->items->count() }} items</span>
                                </td>
                                <td>{{ $menu->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('menus.show', $menu->id) }}" class="btn btn-sm btn-info">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                        <a href="{{ route('menus.edit', $menu->id) }}" class="btn btn-sm btn-warning">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
                                        <a href="{{ route('menu-items.index', ['menu' => $menu->id]) }}" class="btn btn-sm btn-success">
                                            <i class="mdi mdi-format-list-bulleted"></i> Items
                                        </a>
                                        <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" class="d-inline" 
                                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa menu này không? Tất cả menu items sẽ bị xóa theo.');">
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
                
                @if($menus->hasPages())
                <div class="mt-3">
                    {{ $menus->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Menu Preview -->
<div class="row">
    @foreach($menus as $menu)
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ $menu->name }}</h4>
                <p class="card-description">{{ $menu->description }}</p>
                
                @if($menu->items->count() > 0)
                    <div class="menu-preview">
                        <ul class="list-unstyled">
                            @foreach($menu->items as $item)
                                <li class="menu-item mb-2">
                                    <div class="d-flex align-items-center">
                                        @if($item->icon_class)
                                            <i class="{{ $item->icon_class }} me-2"></i>
                                        @endif
                                        <a href="{{ $item->url }}" 
                                           target="{{ $item->target }}" 
                                           class="text-decoration-none">
                                            {{ $item->title }}
                                        </a>
                                        @if(!$item->active)
                                            <span class="badge badge-secondary ms-2">Ẩn</span>
                                        @endif
                                    </div>
                                    
                                    @if($item->children->count() > 0)
                                        <ul class="list-unstyled ms-3 mt-2">
                                            @foreach($item->children as $child)
                                                <li class="mb-1">
                                                    <div class="d-flex align-items-center">
                                                        @if($child->icon_class)
                                                            <i class="{{ $child->icon_class }} me-2"></i>
                                                        @endif
                                                        <a href="{{ $child->url }}" 
                                                           target="{{ $child->target }}" 
                                                           class="text-decoration-none text-muted">
                                                            {{ $child->title }}
                                                        </a>
                                                        @if(!$child->active)
                                                            <span class="badge badge-secondary ms-2">Ẩn</span>
                                                        @endif
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <p class="text-muted">Menu này chưa có item nào.</p>
                @endif
                
                <div class="mt-3">
                    <a href="{{ route('menu-items.create', ['menu' => $menu->id]) }}" class="btn btn-sm btn-primary">
                        <i class="mdi mdi-plus"></i> Thêm Item
                    </a>
                    <a href="{{ route('menus.edit', $menu->id) }}" class="btn btn-sm btn-outline-primary">
                        <i class="mdi mdi-pencil"></i> Sửa Menu
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

@push('styles')
<style>
.menu-preview {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
    border-left: 4px solid #007bff;
}

.menu-item {
    padding: 5px 0;
    border-bottom: 1px solid #eee;
}

.menu-item:last-child {
    border-bottom: none;
}

.menu-item a:hover {
    color: #007bff !important;
}
</style>
@endpush