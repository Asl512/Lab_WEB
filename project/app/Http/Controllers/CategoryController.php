<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Materials;
use App\Models\Links;
use App\Models\Tegs_material;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function category()
    {
        $error = 0;
        $id = null;

        if (isset($_GET['error'])) {
            $error = $_GET['error'];
            $id = Category::select()->where('id_category', $_GET['id'])->first();
        }

        $categoryes = Category::get();
        return view('category')->with(['categoryes' => $categoryes, 'error' => $error, 'id' => $id]);
    }

    public function deleteCategory(Category $category)
    {
        if (count(Materials::select()->where('fk_id_category', $category->id_category)->get()) > 0) {
            return redirect('category?error=1&id=' . $category->id_category);
        } else {
            $category->delete();
            return redirect('category');
        }
    }

    public function deleteEveryMaterials(Category $category) //Удаление материалов с этой категорией
    {
        $materials = Materials::select()->where('fk_id_category', $category->id_category)->get();

        foreach ($materials as $material) {

            //Удаление всех тегов данного материал
            $tags_material = Tegs_material::select()->where('fk_id_material', $material->id_material)->get();
            foreach ($tags_material as $tags_material) {
                $tags_material->delete();
            }

            //Удаление ссылков данного материала
            $links = Links::select()->where('fk_id_material', $material->id_material)->get();
            foreach ($links as $link) {
                $link->delete();
            }

            $material->delete();
        }

        $category->delete();
        return redirect('category');
    }


    public function createCategory(Request $request)
    {
        $request->validate(['name' => 'required|unique:category,name_category']);

        $data = ['name_category' => $request->name];
        Category::create($data);

        return redirect('category');
    }

    public function updateCategory()
    {
        if (isset($_GET['id'])) {
            $category = Category::where('id_category', $_GET['id'])->first();
            if (!$category) {
                return redirect('category');
            } else {
                return view('update-category')->with(['category' => $category]);
            }
        } else {
            return redirect('category');
        }
    }

    public function saveCategory(Request $request, $id)
    {
        $request->validate(['name' => 'required|unique:category,name_category,' . $id . ',id_category']);

        $category = Category::find($id);
        $category->name_category = $request->input('name');
        $category->save();

        return redirect('category');
    }
}
