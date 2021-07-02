<?php

namespace Database\Seeders;

use App\Models\post;
use App\Models\User;
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
        // \App\Models\User::factory(10)->create();
        User::factory()
            ->times(10)
            ->has(post::factory()->count(4))
            ->create();
    }
}
