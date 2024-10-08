<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::factory()->create(['email' => 'admin@mail.ru', 'password' => bcrypt('123456')]);

        Admin::factory()->create(['email' => 'admin2@mail.ru', 'password' => bcrypt('123456')]);
    }
}
