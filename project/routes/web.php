<?php

use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;


Route::get('/', [IndexController::class, "Materials"]);
Route::get('materials', [IndexController::class, "Materials"]);
Route::delete('materials/delete/{material}', [IndexController::class, "Delete_Material"])->name('DeleteM');
Route::post('materials', [IndexController::class, "Search_Materials"])->name("Search");

Route::get('tag', [IndexController::class, "Tag"]);
Route::delete('tag/delete/{tag}', [IndexController::class, "Delete_Tag"])->name('DeleteT');

Route::get('category', [IndexController::class, "Category"]);
Route::delete('category/delete/{category}', [IndexController::class, "Delete_Category"])->name('DeleteC');
Route::delete('category/delever/{category}', [IndexController::class, "Delete_Every_Materials"])->name('DelEver');

Route::get('create-category', [IndexController::class, "Add_category"]);
Route::post('create-category', [IndexController::class, "Save_category"])->name("SaveC");
Route::post('create-category/{id}', [IndexController::class, "Update_category"])->name("UpdateC");

Route::get('create-material', [IndexController::class, "Add_material"]);
Route::post('create-material', [IndexController::class, "Save_material"])->name("SaveM");
Route::post('create-material/{id}', [IndexController::class, "Update_material"])->name("UpdateM");

Route::get('create-teg', [IndexController::class, "Add_teg"]);
Route::post('create-teg', [IndexController::class, "Save_teg"])->name("SaveT");
Route::post('create-teg/{id}', [IndexController::class, "Update_teg"])->name("UpdateT");

Route::get('view-material', [IndexController::class, "View"]);
Route::post('view-material/{id}', [IndexController::class, "Add_tag_material"])->name("AddTM");
Route::delete('view-material/delete/{id}', [IndexController::class, "Delete_Tag_Material"])->name('DeleteTM');
Route::delete('view-material/deleteLM/{id}', [IndexController::class, "Delete_Link_Material"])->name('DeleteLM');
Route::post('view-material/link/{id}', [IndexController::class, "Save_link"])->name("SaveL");
