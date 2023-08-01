<?php

use App\Http\Controllers\{DashboardController, ProfileController, QuestionController};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if(app()->isLocal()) {
        auth()->loginUsingId(1);

        return redirect()->route('dashboard');
    }

    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/question', QuestionController::class);

    Route::post('question/like/{question}', [QuestionController::class, 'like'])->name('question.like');
    Route::post('question/unlike/{question}', [QuestionController::class, 'unlike'])->name('question.unlike');
    Route::put('question/publish/{question}', [QuestionController::class, 'publish'])->name('question.publish');
    Route::put('question/archive/{question}', [QuestionController::class, 'archive'])->name('question.archive');
    Route::put('question/restore/{question}', [QuestionController::class, 'restore'])->name('question.restore');

});

require __DIR__ . '/auth.php';
