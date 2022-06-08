<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Board;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BoardController extends Controller
{
    public function index()
    {
        return Inertia::render('Boards', [
            'boards' => auth()->user()->boards
        ]);
    }

    public function show(Board $board)
    {
        return Inertia::render('Board', [
            'board' => $board
        ]);
    }

    public function update(Board $board)
    {
        request()->validate([
            'name' => ['required', 'max:255']
        ]);

        $board->update(['name' => request('name')]);

        return redirect()->back();
    }

    public function store()
    {
        request()->validate([
            'name' => ['required']
        ]);

        Board::create([
            'user_id' => auth()->id(),
            'name' => request('name')
        ]);

        return redirect()->back();
    }
}
