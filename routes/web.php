<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\PermissinsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use App\Models\Post;
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
    dd(phpinfo());
    $post = Post::find(1);

    return view('welcome');
});

Route::get('/blog', [BlogController::class, 'store']);
Route::get('/download', [TestController::class, 'download']);
Route::get('/bulk-upload', [TestController::class, 'bulkUpload']);

Route::get('/exception', [TestController::class, 'exception']);


Route::get('/permit', [PermissinsController::class, 'permit']);
Route::get('/can-view', [PermissinsController::class, 'canView'])->middleware('permission:read');

Route::get('/oneToOne', [TestController::class, 'oneToOne']);
Route::get('/oneToMany', [TestController::class, 'oneToMany']);
Route::get('/hasOne', [TestController::class, 'hasOne']);
Route::get('/has-one-through', [TestController::class, 'has_one_through']);
Route::get('/many-to-many', [TestController::class, 'many_to_many']);
Route::get('/one-to-one-polymorphic-relations', [TestController::class, 'one_one_polymorphic_relations']);

Route::get('/accessors', [TestController::class, 'accessors']);
Route::get('/muttators', [TestController::class, 'muttators']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
