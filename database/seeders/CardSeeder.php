<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\User;
use App\Models\Board;
use App\Models\CardList;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(1);
        $boards = Board::all();
        $cardLists = CardList::all();

        foreach ($boards as $board) {
            foreach ($cardLists as $cardList) {
                Card::factory(50)->create([
                    'board_id' => $board->id,
                    'user_id' => $user->id,
                    'card_list_id' => $cardList->id
                ]);
            }
        }
    }
}
