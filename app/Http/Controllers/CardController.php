<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CardController extends Controller
{
    public function store()
    {
        request()->validate([
            'board_id' => ['required', 'exists:boards,id'],
            'card_list_id' => ['required', 'exists:card_lists,id'],
            'title' => ['required']
        ]);

        Card::create([
            'board_id' => request('board_id'),
            'card_list_id' => request('card_list_id'),
            'title' => request('title'),
            'user_id' => auth()->id()
        ]);

        return redirect()->back();
    }

    public function update(Card $card)
    {
        request()->validate([
            'title' => ['required']
        ]);

        $card->update(['title' => request('title')]);

        return redirect()->back();
    }
}
