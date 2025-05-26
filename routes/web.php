<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThingController;
use App\Http\Controllers\DrawingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ParcelMapController;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\DeliveryController;




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
     Route::post('/profile/create', [ThingController::class, 'store'])->name('thing.store');

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
// Route::get('/draw/from-thing/{thing}', [DrawingController::class, 'createFromThing'])->name('draw.fromThing');
Route::get('/draw/choose-thing', [DrawingController::class, 'chooseThing'])->name('draw.chooseThing');
Route::get('/draw/from-thing/{thing}', [DrawingController::class, 'createFromThing'])->name('draw.fromThing');


    });
   
    

    Route::post('/drawings', [DrawingController::class, 'store'])->name('drawings.store');
    Route::get('/gallery/my', [DrawingController::class, 'my'])->middleware('auth')->name('drawings.my');
});
Route::get('/gallery', [DrawingController::class, 'index'])->name('drawings.gallery');
Route::get('/gallery/{id}', [DrawingController::class, 'show'])->name('drawings.show');
Route::get('/drawings/search', [DrawingController::class, 'search'])->name('drawings.search');
Route::get('/drawings', [DrawingController::class, 'index'])->name('drawings.index');
// parcel machine
Route::get('/parcel-map', [ParcelMapController::class, 'index'])->name('parcel-map');

Route::delete('/profile/avatar', [\App\Http\Controllers\ProfileController::class, 'deleteAvatar'])
    ->name('profile.avatar.delete');

Route::get('/drawings/{drawing}/parcel-map', [ParcelMapController::class, 'showParcelMap'])->name('drawings.parcel-map');
Route::post('/drawings/{drawing}/choose-parcel', [ParcelMapController::class, 'chooseParcel'])->name('drawings.choose-parcel');

Route::middleware(['auth'])->group(function () {
    Route::get('/my-deliveries', [DeliveryController::class, 'allDeliveries'])->name('deliveries.all');
    Route::get('/deliveries/{delivery}', [DeliveryController::class, 'show'])->name('deliveries.show');
    Route::get('/drawings/{drawing}/delivery', [DeliveryController::class, 'show'])->name('deliveries.show.drawing');
    Route::get('/drawings/{drawing}/delivery/create', [DeliveryController::class, 'create'])->name('deliveries.create');
    Route::post('/drawings/{drawing}/delivery', [DeliveryController::class, 'store'])->name('deliveries.store');
    Route::delete('/deliveries/{delivery}', [DeliveryController::class, 'destroy'])->name('deliveries.destroy');
});
Route::redirect('/profile', '/profile/edit');

require __DIR__.'/auth.php';

