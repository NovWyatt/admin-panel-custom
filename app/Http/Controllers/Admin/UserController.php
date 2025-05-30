<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with('roles')->select('users.*');
            
            return DataTables::of($users)
                ->addColumn('roles', function ($user) {
                    return $user->roles->pluck('name')->implode(', ');
                })
                ->addColumn('action', function ($user) {
                    $actions = '<div class="btn-group" role="group">';
                    $actions .= '<a href="' . route('users.show', $user->id) . '" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>';
                    $actions .= '<a href="' . route('users.edit', $user->id) . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>';
                    $actions .= '<form action="' . route('users.destroy', $user->id) . '" method="POST" class="d-inline" onsubmit="return confirm(\'Bạn có chắc chắn muốn xóa người dùng này không?\');">';
                    $actions .= csrf_field();
                    $actions .= method_field('DELETE');
                    $actions .= '<button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>';
                    $actions .= '</form>';
                    $actions .= '</div>';
                    
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'is_admin' => 'boolean',
            'roles' => 'array',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->has('is_admin'),
        ]);

        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }

        ActivityLogService::log('created', 'User', $user->id, 'Người dùng mới được tạo: ' . $user->name);

        return redirect()->route('users.index')->with('success', 'Người dùng đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $activities = $user->activityLogs()->latest()->paginate(10);
        return view('admin.users.show', compact('user', 'activities'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $userRoles = $user->roles->pluck('id')->toArray();
        
        return view('admin.users.edit', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'is_admin' => 'boolean',
            'roles' => 'array',
        ]);

        $oldValues = $user->toArray();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->is_admin = $request->has('is_admin');
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();

        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        } else {
            $user->syncRoles([]);
        }

        ActivityLogService::log('updated', 'User', $user->id, 'Người dùng được cập nhật: ' . $user->name, $oldValues, $user->toArray());

        return redirect()->route('users.index')->with('success', 'Người dùng đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $userName = $user->name;
        
        $user->delete();

        ActivityLogService::log('deleted', 'User', $user->id, 'Người dùng đã bị xóa: ' . $userName);

        return redirect()->route('users.index')->with('success', 'Người dùng đã được xóa thành công!');
    }
}