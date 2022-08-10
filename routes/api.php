<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Usercontroller;
use App\Http\Controllers\Api\BlogController;
use GuzzleHttp\Middleware;




Route::post('register', [Usercontroller::class, 'register']);
Route::post('login', [Usercontroller::class, 'login']);

Route::group(['middleware'=>["auth:sanctum"]],function(){
    //rutas Auth
    Route::get('user-profile', [Usercontroller::class, 'userProfile']);
    Route::get('logout', [Usercontroller::class, 'logout']);

    //rutas Blog
    Route::post("create-blog", [BlogController::class,"createBlog"]);
    Route::get("list-blog", [BlogController::class,"listBlog"]);
    Route::get("show-blog/{id}", [BlogController::class,"showBlog"]);
    Route::put("update-blog/{id}", [BlogController::class,"updateBlog"]);
    Route::delete("delete-blog/{id}", [BlogController::class,"deleteBlog"]);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



