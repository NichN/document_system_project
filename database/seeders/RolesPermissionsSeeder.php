<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles_permissions')->truncate();

        DB::table('roles_permissions')->insert([
            ['role' => 'Super Admin', 'can_upload' => true, 'can_download' => true, 'can_comment' => true, 'can_rate' => true, 'can_view' => true],
            ['role' => 'Admin', 'can_upload' => true, 'can_download' => true, 'can_comment' => true, 'can_rate' => true, 'can_view' => true],
            ['role' => 'Teacher', 'can_upload' => true, 'can_download' => true, 'can_comment' => false, 'can_rate' => false, 'can_view' => true],
            ['role' => 'Student', 'can_upload' => false, 'can_download' => true, 'can_comment' => true, 'can_rate' => true, 'can_view' => true],
            ['role' => 'Guest', 'can_upload' => false, 'can_download' => false, 'can_comment' => false, 'can_rate' => false, 'can_view' => true],
        ]);
    }
}
