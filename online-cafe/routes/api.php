<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\ChecksController;

use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\RoomController;
use App\Models\User;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\AdminUserController;
use App\Http\Controllers\api\CheckOrderController ;
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
// middleware('auth:sanctum')->get


Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth')->get('/testapi', function (Request $request) {
    return response()->json(["message" => "New post added successfully"]);
});


Route::group(['middleware' => ['auth:sanctum']], function () {

    // orders
    Route::get("/order/latest", [OrderController::class, 'latest'])->name('latestOrder');
    Route::get("/order/cancel/{id}", [OrderController::class, 'cancelOrder'])->name('latestOrder');
    Route::get("/order/products/{id}", [OrderController::class, 'getOrderProducts'])->name('orderProducts');
    Route::apiResource('/order', OrderController::class);

    Route::get("/users", function () {
        return User::all();
    });

    // ... Other routes
    Route::apiResource("/rooms",RoomController::class);
    Route::apiResource("/products", ProductController::class);
    Route::apiResource("/categories", CategoryController::class);
    Route::put("/products/available/{product}", [ProductController::class, 'available']);
    

    // users
    Route::post('/userstore',[AdminUserController::class,'store']); 
    Route::get('/userindex',[AdminUserController::class,'index']); 
    Route::delete('/userdelete/{id}',[AdminUserController::class,'destroy']); 
    Route::patch('/useredit/{id}',[AdminUserController::class,'update']); 
    Route::get('/usershow/{id}',[AdminUserController::class,'show']); 
    
    // checks
    Route::post('/checks', [ChecksController::class, 'store']);
    Route::get('/checks', [ChecksController::class, 'index']);


    Route::post('/checks/products', [ChecksController::class, 'getProducts']);

    Route::post('/checkOrder',[CheckOrderController::class,'index']);
    Route::put('/checkOrder',[CheckOrderController::class,'update']);

});

//Route::apiResource("/checks",ChecksController::class);

