<?php

use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [IndexController::class, "Index"]);
Route::get('index', [IndexController::class, "Index"]);
Route::post('index/{product}', [IndexController::class, "Bascket"])->name('Bas');

Route::get('everyorder', [IndexController::class, "Everyorder"]);
Route::post('everyorder', [IndexController::class, "AddStaffOrder"])->name('AddStOr');

Route::get('staff', [IndexController::class, "Staff"]);
Route::post('staff', [IndexController::class, "AddStaff"])->name('AddSt');
Route::delete('staff/delete/{user}', [IndexController::class, "DeleteStaff"])->name('DeleteSt');

Route::get('order', [IndexController::class, "Order"]);
Route::post('order', [IndexController::class, "AddOrders"])->name('AddO');
Route::delete('order/delete/{product}', [IndexController::class, "DeleteBascket"])->name('DeleteB');

Route::get('suppli', [IndexController::class, "Suppli"]);
Route::post('suppli', [IndexController::class, "AddSuppli"])->name('AddS');

Route::get('updateorder', [IndexController::class, "UpdateOrder"]);
Route::post('updateorder', [IndexController::class, "SaveOrder"])->name('SaveO');

Route::get('updateproduct', [IndexController::class, "UpdateProduct"]);
Route::post('updateproduct', [IndexController::class, "SaveProduct"])->name('SaveP');
Route::get('myorder', [IndexController::class, "Myorder"]);
Route::delete('myorder/delete/{order}', [IndexController::class, "DeleteOrder"])->name('DeleteO');
Route::post('myorder', [IndexController::class, "Oplatit"])->name('Oplatittt');

Route::get('myorderstaff', [IndexController::class, "Myorderstaff"]);
Route::post('myorderstaff', [IndexController::class, "MyorderstaffAdd"])->name('AddMyOrSt');

Route::get('mysuppli', [IndexController::class, "Mysuppli"]);

Route::get('reports', [IndexController::class, "Reports"]);
Route::post('reports', [IndexController::class, "POSTsale"])->name('PostS');

Route::get('sale', [IndexController::class, "Sale"]);

Route::get('product', [IndexController::class, "Product"]);
Route::post('product', [IndexController::class, "AddProduct"])->name('AddP');
Route::delete('product/delete/{product}', [IndexController::class, "DeleteProduct"])->name('DeleteP');

Auth::routes();
Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, "logout"]);