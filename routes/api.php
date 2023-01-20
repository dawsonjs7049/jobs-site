<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// example of api route (we are responding with json) -> Have to prefix url with /api so www.name/api/posts
Route::get('/posts', function() {
    return response()->json([
        'posts' => [
            [
                'title' => 'post1'
            ]
        ]
    ]);
});
