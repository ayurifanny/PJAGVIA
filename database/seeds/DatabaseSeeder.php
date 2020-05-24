<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = App\User::create([
            'name' => 'Admin',
            'email' => 'admin1@example.com',
            'password' => '$2y$10$B17Uj4DH2GruuxyLA2fjb.z79Q8pQ4oJjI6HuuQvDmT7ECOc2EXQm',
        ]);

        Role::create([
            'name' => 'customer',
            'guard_name' => 'web',
        ]);

        Role::create([
            'name' => 'inspector',
            'guard_name' => 'web',
        ]);

        Role::create([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $user->assignRole('admin');
    }
}
