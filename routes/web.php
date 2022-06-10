<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\CardListController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['auth', 'verified']], function() {
    Route::get('/board/{board}', [BoardController::class, 'show'])->name('boards.show');
    Route::put('/boards/{board}', [BoardController::class, 'update'])->name('boards.update');
    Route::get('/boards', [BoardController::class, 'index'])->name('boards');
    Route::post('/boards', [BoardController::class, 'store'])->name('boards.store');
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
   })->name('dashboard');

   Route::post('/boards/{board}/lists', [CardListController::class, 'store'])->name('cardLists.store');
});


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');


Route::middleware(['auth'])->group(function () {
    Route::get('/wall', [PostController::class, 'index'])->name('wall')->middleware('can:show posts');

    Route::get('add-post', [PostController::class, 'create'])->name('add-post')->middleware('can:add posts');
    Route::post('store-post', [PostController::class, 'store'])->name('store-post')->middleware('can:add posts');
    Route::get('edit-post/{id}', [PostController::class, 'edit'])->name('edit-post')->middleware('can:edit posts');
    Route::put('update-post/{id}', [PostController::class, 'update'])->name('update-post')->middleware('can:edit posts');
    Route::delete('delete-post/{id}', [PostController::class, 'delete'])->name('delete-post')->middleware('can:delete posts');

    Route::resource('roles', RoleController::class)->middleware('role:super-user');
    Route::resource('users', UserController::class)->middleware('role:super-user');
});



require __DIR__.'/auth.php';
