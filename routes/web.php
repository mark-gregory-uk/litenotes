<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataFeedController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TrashedNoteController;
use Illuminate\Support\Facades\Route;

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

Route::redirect('/', 'login');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/note/{id}/archive', [NoteController::class, 'archive'])->name('note.archive');
    Route::get('/note/{id}/unarchive', [NoteController::class, 'unArchive'])->name('note.unuarchive');
    Route::get('/notes/archived', [NoteController::class, 'archived'])->name('notes.archived');
    Route::get('/notes/{id}/archive', [NoteController::class, 'archivedShow'])->name('notes.show.archived');
    Route::get('/notes/{id}/archive/edit', [NoteController::class, 'editArchived'])->name('notes.edit.archived');
    Route::put('/notes/{id}/archive/update', [NoteController::class, 'updateArchive'])->name('notes.update.archived');

    Route::delete('/note/{id}/delete', [NoteController::class, 'destroy'])->name('note.trash');

    Route::resource('/notes', NoteController::class);

    // Route for the getting the data feed
    Route::get('/json-data-feed', [DataFeedController::class, 'getDataFeed'])->name('json_data_feed');

    Route::prefix('/trashed')->name('trashed.')->group(function () {
        Route::get('/', [TrashedNoteController::class, 'index'])->name('index');
        Route::get('/{note}', [TrashedNoteController::class, 'show'])->withTrashed()->name('show');
        Route::get('/{note}', [TrashedNoteController::class, 'destroy'])->withTrashed()->name('destroy');
        Route::get('/{note}/destroy', [TrashedNoteController::class, 'update'])->withTrashed()->name('update');
    });

    Route::prefix('/categories')->name('categories.')->group(function () {
        Route::get('/', [CategoriesController::class, 'index'])->name('index');
        Route::post('/create', [CategoriesController::class, 'create'])->name('create');
        Route::get('/{category}', [CategoriesController::class, 'show'])->name('show');
        Route::delete('/{category}', [CategoriesController::class, 'destroy'])->name('destroy');
        Route::put('/{category}', [CategoriesController::class, 'update'])->name('update');
    });


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::fallback(function () {
        return view('pages/utility/404');
    });
});
