<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateDefaultAdminUser extends Migration
{
    public function up()
    {
        // Tạo người dùng admin mặc định
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Tạo vai trò admin
        $adminRole = Role::create(['name' => 'admin']);
        
        // Tạo quyền hạn
        $permissions = [
            'browse_admin',
            'browse_users',
            'read_users',
            'edit_users',
            'add_users',
            'delete_users',
            'browse_roles',
            'read_roles',
            'edit_roles',
            'add_roles',
            'delete_roles',
            'browse_permissions',
            'read_permissions',
            'edit_permissions',
            'add_permissions',
            'delete_permissions',
            'browse_settings',
            'read_settings',
            'edit_settings',
            'add_settings',
            'delete_settings',
            'browse_menus',
            'read_menus',
            'edit_menus',
            'add_menus',
            'delete_menus',
            'browse_menu_items',
            'read_menu_items',
            'edit_menu_items',
            'add_menu_items',
            'delete_menu_items',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        
        // Gán tất cả quyền cho vai trò admin
        $adminRole->givePermissionTo(Permission::all());
        
        // Gán vai trò admin cho người dùng admin
        $admin->assignRole($adminRole);
    }

    public function down()
    {
        // Xóa người dùng admin
        $admin = User::where('email', 'admin@admin.com')->first();
        if ($admin) {
            $admin->delete();
        }
        
        // Xóa vai trò admin
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $adminRole->delete();
        }
        
        // Xóa quyền hạn
        Permission::whereIn('name', [
            'browse_admin',
            'browse_users',
            'read_users',
            'edit_users',
            'add_users',
            'delete_users',
            'browse_roles',
            'read_roles',
            'edit_roles',
            'add_roles',
            'delete_roles',
            'browse_permissions',
            'read_permissions',
            'edit_permissions',
            'add_permissions',
            'delete_permissions',
            'browse_settings',
            'read_settings',
            'edit_settings',
            'add_settings',
            'delete_settings',
            'browse_menus',
            'read_menus',
            'edit_menus',
            'add_menus',
            'delete_menus',
            'browse_menu_items',
            'read_menu_items',
            'edit_menu_items',
            'add_menu_items',
            'delete_menu_items',
        ])->delete();
    }
}