<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsTableSeeder extends Seeder
{
    /**
     * The permissions to be seeded.
     *
     * @var array
     */
    protected $permissions = [
        'administrator' => [
            'view backend',
        ],

        'user' => [
            //
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Role::create(['name' => 'super administrator']);

        foreach ($this->permissions as $role => $permissions) {
            foreach ($permissions as $permission) {
                Permission::findOrCreate($permission);
            }

            Role::create(['name' => $role])
                ->givePermissionTo($permissions);
        }
    }
}
