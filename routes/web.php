<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThingController;
use App\Http\Controllers\DrawingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;

use Illuminate\Support\Facades\Mail;

Route::get('/send-test-email', function () {
    Mail::raw('This is a test email from Laravel using Mailtrap!', function ($message) {
        $message->to('test@example.com')
                ->subject('Test Email');
    });

    return 'Test email sent!';
});
Route::get('/', function () {
    return view('welcome');
})->name('welcome');
// likes
Route::middleware(['auth'])->group(function () {
    Route::post('/drawings/{drawing}/like', [LikeController::class, 'toggleLike'])->name('drawings.like');
    //comments
    Route::post('/drawings/{drawing}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});



Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

     Route::get('/profile/create', [ThingController::class, 'create'])->name('profile.create');
     Route::post('/profile/store', [ThingController::class, 'store'])->name('profile.store');
          // Thing routes
     Route::get('/things', [ThingController::class, 'index'])->name('things.index');
     Route::get('/things/{thing}', [ThingController::class, 'show'])->name('things.show');
     Route::get('/things/{thing}/edit', [ThingController::class, 'edit'])->name('things.edit');
     Route::patch('/things/{thing}', [ThingController::class, 'update'])->name('things.update');
     Route::delete('/things/{thing}', [ThingController::class, 'destroy'])->name('things.destroy');
     Route::get('/draw', [DrawingController::class, 'create'])->name('draw');
});
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


 

    // Drawing routes
 
    Route::middleware(['auth'])->group(function () {
        Route::resource('drawings', DrawingController::class);
        Route::get('/drawings/{drawing}/edit', [DrawingController::class, 'edit'])->name('drawings.edit');
Route::put('/drawings/{drawing}', [DrawingController::class, 'update'])->name('drawings.update');
Route::delete('/drawings/{drawing}', [DrawingController::class, 'destroy'])->name('drawings.destroy');
    });
   
    

    Route::post('/drawings', [DrawingController::class, 'store'])->name('drawings.store');
    Route::get('/gallery/my', [DrawingController::class, 'my'])->middleware('auth')->name('drawings.my');
});
Route::get('/gallery', [DrawingController::class, 'index'])->name('drawings.gallery');
Route::get('/gallery/{id}', [DrawingController::class, 'show'])->name('drawings.show');
Route::get('/drawings/search', [DrawingController::class, 'search'])->name('drawings.search');





require __DIR__.'/auth.php';
