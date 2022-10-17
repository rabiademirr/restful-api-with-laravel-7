<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UploadController;
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
Route::post('auth/login/', [LoginController::class,'index']);

Route::get('/users', function () {
    return App\Models\User::factory(10)->create();
});

//Route::resource('/products',ProductController::class)->only(['index','create']);
//Route::resource('/products',ProductController::class)->except(['destroy']);

//Route::apiResource('products', ProductController::class);
//Route::apiResource('users',UserController::class);
//Route::apiResource('categories',CategoryController::class);

Route::get('categories/custom1',[CategoryController::class,'custom1'])->middleware('auth:sanctum');
Route::get('products/custom1',[ProductController::class,'custom1']);
Route::get('products/custom2',[ProductController::class,'custom2']);
Route::get('categories/report1',[CategoryController::class,'report1']);
Route::get('products/paginate',[ProductController::class,'paginate']);
Route::get('products/listwithcategories',[ProductController::class,'listWithCategories']);

Route::middleware('auth:api')->group(function (){
    Route::apiResources([
        'products' => ProductController::class,
        'users' => UserController::class,
        'categories' =>CategoryController::class
    ]);
});



Route::post('auth/logins',[AuthController::class,'login']);
Route::post('/upload',[UploadController::class,'upload']);
