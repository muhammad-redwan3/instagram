<?php

namespace Database\Seeders;

use App\Models\comment;
use Illuminate\Database\Seeder;

class commentseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        comment::factory()->times(40)->create();
    }
}
