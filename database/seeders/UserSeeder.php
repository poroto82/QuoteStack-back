<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserQuote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->count(3)
            ->has(UserQuote::factory()->count(3), 'quotes')
            ->create();
    }
}
