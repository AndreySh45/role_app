<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Board;
use Illuminate\Database\Seeder;
use Database\Seeders\CardSeeder;
use Database\Seeders\CardListSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
        $this->call(CardListSeeder::class);
        $this->call(CardSeeder::class);

    }
}
