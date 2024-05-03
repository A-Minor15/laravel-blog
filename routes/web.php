<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    # Note: The route inside this group is NOT ACCESSIBLE to users that are not
    # registered and logged-in to our application. The route here is protected with the "middleware => auth"
    //Route::get('/', [HomeController::class, 'index'])->name('index'); //homepage
    Route::get('/', [PostController::class, 'index'])->name('index'); //homepage

    # Post
    Route::group(['prefix' => 'post', 'as' => 'post.'], function(){
        Route::get('/create', [PostController::class, 'create'])->name('create'); //post.create
        Route::post('/store', [PostController::class, 'store'])->name('store'); //post.store
        Route::get('/{id}/show', [PostController::class, 'show'])->name('show'); //post.show
        Route::get('/{id}/edit', [PostController::class, 'edit'])->name('edit'); //post.edit
        Route::patch('/{id}/update', [PostController::class, 'update'])->name('update'); //post.update
        Route::delete('/{id}/destroy', [PostController::class, 'destroy'])->name('destroy'); //post.destroy
    });

    # Comment
    Route::group(['prefix' => 'comment', 'as' => 'comment.'], function() {
        Route::post('/{post_id}/store', [CommentController::class, 'store'])->name('store');
        Route::delete('/{id}/destroy', [CommentController::class, 'destroy'])->name('destroy');
    });

    # Profile
    Route::Group(['prefix' => 'profile', 'as' => 'profile.'], function() {
        Route::get('/', [UserController::class, 'show'])->name('show');
    });
});


