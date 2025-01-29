<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\User;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // パーミッションの作成
        $permissions = [
            'assign_manager',
            'edit_shop',
            'delete_review',
            'book_restaurant',
            'post_review'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // ロールの作成
        $adminRole = Role::create(['name' => 'admin']);
        $managerRole = Role::create(['name' => 'manager']);
        $userRole = Role::create(['name' => 'user']);

        // パーミッション付与
        $adminRole->givePermissionTo(['assign_manager', 'edit_shop', 'delete_review']);
        $managerRole->givePermissionTo(['edit_shop']);
        $userRole->givePermissionTo(['post_review', 'delete_review', 'book_restaurant']);

        // 管理者ユーザのダミーデータ作成
        $admin = User::create([
            'name' => '管理者',
            'email' => 'admin@resetestuser.com',
            'password' => Hash::make('Admin-1234'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        // 店舗代表者のダミーデータ作成
        $manager = User::create([
            'name' => '店舗代表者1',
            'email' => 'testmanager1@resetestuser.com',
            'password' => Hash::make('Manager1-1234'),
            'email_verified_at' => now(),
        ]);
        $manager->assignRole('manager');

        // 一般ユーザ
        User::factory()
            ->count(25)
            ->create()
            ->each(fn($user) => $user->assignRole('user'));
    }
}
