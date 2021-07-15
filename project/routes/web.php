<?php

use App\Http\Controllers\ViewController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;


Route::get('/', [MaterialController::class, "materials"])->name('Materials');
Route::get('materials', [MaterialController::class, "materials"])->name('Materials');
Route::delete('materials/delete/{material}', [MaterialController::class, "deleteMaterial"])->name('DeleteM');

Route::get('create-material', [MaterialController::class, "createMaterial"]);
Route::post('create-material', [MaterialController::class, "addMaterial"])->name("AddM");

Route::get('update-material', [MaterialController::class, "updateMaterial"]);
Route::post('update-material/{material}', [MaterialController::class, "saveMaterial"])->name("SaveM");



Route::get('category', [CategoryController::class, "category"]);
Route::delete('category/delete/{category}', [CategoryController::class, "deleteCategory"])->name('DeleteC');
Route::delete('category/delever/{category}', [CategoryController::class, "deleteEveryMaterials"])->name('DelEver');

Route::get('create-category', function () {
    return view('create-category');
});

Route::post('create-category', [CategoryController::class, "createCategory"])->name("CreateC");

Route::get('update-category', [CategoryController::class, "updateCategory"]);
Route::post('update-category/{id}', [CategoryController::class, "saveCategory"])->name("SaveC");



Route::get('tag', [TagController::class, "tag"]);
Route::delete('tag/delete/{tag}', [TagController::class, "deleteTag"])->name('DeleteT');

Route::get('create-teg', function () {
    return view('create-teg');
});

Route::post('create-teg', [TagController::class, "createTag"])->name("CreateT");

Route::get('update-teg', [TagController::class, "updateTag"]);
Route::post('update-teg/{tag}', [TagController::class, "saveTag"])->name("SaveT");



Route::get('view-material', [ViewController::class, "View"]);

Route::post('view-material/{id_material}', [ViewController::class, "addTagMaterial"])->name("AddTM");
Route::delete('view-material/delete/{tag_material}', [ViewController::class, "deleteTagMaterial"])->name('DeleteTM');
Route::delete('view-material/deleteLM/{link}', [ViewController::class, "deleteLinkMaterial"])->name('DeleteLM');

Route::post('view-material/addlink/{id_material}', [ViewController::class, "addlink"])->name("AddL");
Route::post('view-material/updatelink/{link}', [ViewController::class, "savelink"])->name("SaveL");
