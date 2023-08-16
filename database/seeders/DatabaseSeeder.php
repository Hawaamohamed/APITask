<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([ 
            
            RoleSeeder::class,
            PermissionSeeder::class,

        ]);
        $this->command->info('========== Start Admin Panel===========');
        $this->command->info('email: admin@admin.com');
        $this->command->info('pass: 123456');
        $this->command->info('========== Start Admin Panel===========');
    }
}
