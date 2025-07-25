<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Livewire\Categories;
use App\Livewire\CategoriesCreate;
use App\Livewire\CategoriesEdit;
use App\Livewire\CategoriesShow;
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
