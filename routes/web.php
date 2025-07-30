<?php

use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\TagController;
use App\Livewire\Archive;
use App\Livewire\ArchiveShow;
use App\Livewire\Categories;
use App\Livewire\CategoriesCreate;
use App\Livewire\CategoriesEdit;
use App\Livewire\CategoriesShow;
use App\Livewire\Entries;
use App\Livewire\EntriesCreate;
use App\Livewire\EntriesEdit;
use App\Livewire\EntriesShow;
use App\Livewire\FileUpload;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Tags;
use App\Livewire\TagsCreate;
use App\Livewire\TagsEdit;
use App\Livewire\TagsShow;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    /* ENTRIES */
    Route::get('/entries', Entries::class)->name('entries.index');
    Route::get('/entries/create', EntriesCreate::class)->name('entries.create');
    Route::get('/entries/show/{entry}', EntriesShow::class)->name('entries.show');
    Route::delete('/entries/{entry}', [EntryController::class, 'destroy'])->name('entries.destroy');
    Route::get('/entries/edit/{entry}', EntriesEdit::class)->name('entries.edit');

     /* ARCHIVE */
    Route::get('/archive', Archive::class)->name('archive.index');
    Route::get('/archive/show/{archive}', ArchiveShow::class)->name('archive.show');
    Route::put('/archive/{archive}', [ArchiveController::class, 'restore'])->name('archive.restore');
    Route::delete('/archive/{archive}', [ArchiveController::class, 'destroy'])->name('archive.destroy');

    /* FILES */
    Route::get('/entries/{entry}/file', FileUpload::class)->name('files.upload');
    Route::delete('/sports/{entry}/file/{file}', [FileController::class, 'destroy'])->name('files.destroy');

    Route::delete('/sports/{entry}/file/{file}', [FileController::class, 'destroy'])->name('files.destroy');

    /* CATEGORIES */
    Route::get('/categories', Categories::class)->name('categories.index');
    Route::get('/categories/create', CategoriesCreate::class)->name('categories.create');
    Route::get('/categories/show/{category}', CategoriesShow::class)->name('categories.show');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('/categories/edit/{category}', CategoriesEdit::class)->name('categories.edit');

    /* TAGS */
    Route::get('/tags', Tags::class)->name('tags.index');
    Route::get('/tags/create', TagsCreate::class)->name('tags.create');
    Route::get('/tags/show/{tag}', TagsShow::class)->name('tags.show');
    Route::put('/tags/{tag}', [TagController::class, 'update'])->name('tags.update');
    Route::delete('/tags/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');
    Route::get('/tags/edit/{tag}', TagsEdit::class)->name('tags.edit');

});

require __DIR__.'/auth.php';
