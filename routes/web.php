<?php

use App\Http\Controllers\ListingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Listing;
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

// show create form
Route::get('/listings/create', [ListingController::class, 'create']);

// store listing data from form
Route::post('/listings', [ListingController::class, 'store']);

// single listing - should be beneath the show create since any /listings path will assume its a {listing} id instead otherwise
// manual way of doing it (we would have listing/{id} and pass $id into callback function)
    // -> return view('listing', [ 'listing' => Listing::find($id) ]);
Route::get('/listings/{listing}', [ListingController::class, 'show']);










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