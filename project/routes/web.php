<?php

use App\Http\Controllers\ViewController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;


Route::get('/', [MaterialController::class, "Materials"])->name('Materials');
Route::get('materials', [MaterialController::class, "Materials"])->name('Materials');
Route::delete('materials/delete/{material}', [MaterialController::class, "Delete_Material"])->name('DeleteM');

Route::get('create-material', [MaterialController::class, "CreateMaterial"]);
Route::post('create-material', [MaterialController::class, "AddMaterial"])->name("AddM");

Route::get('update-material', [MaterialController::class, "UpdateMaterial"]);
Route::post('update-material/{id}', [MaterialController::class, "SaveMaterial"])->name("SaveM");



Route::get('category', [CategoryController::class, "Category"]);
Route::delete('category/delete/{category}', [CategoryController::class, "Delete_Category"])->name('DeleteC');
Route::delete('category/delever/{category}', [CategoryController::class, "Delete_Every_Materials"])->name('DelEver');

Route::get('create-category', function () {return view('create-category');});
Route::post('create-category', [CategoryController::class, "CreateCategory"])->name("CreateC");

Route::get('update-category', [CategoryController::class, "UpdateCategory"]);
Route::post('update-category/{id}', [CategoryController::class, "SaveCategory"])->name("SaveC");



Route::get('tag', [TagController::class, "Tag"]);
Route::delete('tag/delete/{tag}', [TagController::class, "Delete_Tag"])->name('DeleteT');

Route::get('create-teg', function () {return view('create-teg');});
Route::post('create-teg', [TagController::class, "CreateTag"])->name("CreateT");

Route::get('update-teg', [TagController::class, "UpdateTag"]);
Route::post('update-teg/{id}', [TagController::class, "SaveTag"])->name("SaveT");



Route::get('view-material', [ViewController::class, "View"]);

Route::post('view-material/{id}', [ViewController::class, "AddTagMaterial"])->name("AddTM");
Route::delete('view-material/delete/{id}', [ViewController::class, "DeleteTagMaterial"])->name('DeleteTM');
Route::delete('view-material/deleteLM/{id}', [ViewController::class, "DeleteLinkMaterial"])->name('DeleteLM');

Route::get('create-link', [ViewController::class, "CreateLink"]);
Route::post('create-link/{id}', [ViewController::class, "Addlink"])->name("AddL");

Route::get('update-link', [ViewController::class, "UpdateLink"]);
Route::post('update-link/{link}', [ViewController::class, "Savelink"])->name("SaveL");
