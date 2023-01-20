<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;
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

// all listings
Route::get('/', [ListingController::class, 'index']);

// show create form - if user is not logged in, they cant see this, redirects them back to login page (named below)
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

// store listing data from form
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

// show edit form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

// update listing
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

// delete listing 
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

// show register create form - if you are already logged in will redirect you to guest page
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

// manage listings
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');

// single listing - should be beneath the show create since any /listings path will assume its a {listing} id instead otherwise
// manual way of doing it (we would have listing/{id} and pass $id into callback function)
    // -> return view('listing', [ 'listing' => Listing::find($id) ]);
Route::get('/listings/{listing}', [ListingController::class, 'show']);

// create new user
Route::post('/users', [UserController::class, 'store']);

// logout user 
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// show login form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

// login the user
Route::post('/users/authenticate', [UserController::class, 'authenticate']);




// EXAMPLES

// example page
Route::get('/hello', function() {
    return 'Hello World';
});

// example with a response, you can set headers with this
Route::get('/hello2', function() {
    return response('<h1>Hello World</h1>', 200)
        ->header('Content-Type', 'text/plain')
        ->header('foo', 'bar');
});

// example with wildcard 
Route::get('/posts/{id}', function($id) {
    return response('Id ' . $id);
});

// constraint on what you can pass in the url
Route::get('/number/{number}', function($number) {

    // tells you whats passed in
    // dd($number);

    // tells you whats passed in with debug ingo
    // ddd($number);

    return response('Number ' . $number);
})->where('number', '[0-9]+');

// getting search parameters from url
Route::get('/search', function(Request $request) {
    return ($request->name . ' ' . $request->city);
});