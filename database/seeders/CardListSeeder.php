<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Board;
use App\Models\CardList;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CardListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(1);
        $boards = Board::factory(5)->for($user)->create();

        foreach ($boards as $board) {
            $cardList = CardList::factory()->create([
                'board_id' => $board->id,
                'user_id' => $user->id
            ]);
        }
    }
}
