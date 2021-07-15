<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Materials;
use App\Models\Links;
use App\Models\Tegs_material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    static $Types = ['Книга', 'Статья', 'Видео', 'Сайт/Блог', 'Подборка', 'Ключевые идеи книги'];

    public function materials(Request $request)
    {
        if ($request->input('search')) {
            $search = $request->input('search');
            $materials = Materials::select()->join('category', 'material.fk_id_category', '=', 'category.id_category')

                ->join('tegs_material', 'material.id_material', '=', 'tegs_material.fk_id_material')
                ->join('teg', 'tegs_material.fk_id_teg', '=', 'teg.id_teg')

                ->where('material.name_material', $search)
                ->orWhere('material.autors', $search)
                ->orWhere('material.type', $search)
                ->orWhere('category.name_category', $search)
                ->orWhere('teg.name_teg', $search)->get();
        } else {
            $materials = Materials::select()->join('category', 'material.fk_id_category', '=', 'category.id_category')->get();
        }

        return view('materials')->with(['materials' => $materials, 'search' => $request->input('search')]);
    }

    public function createMaterial()
    {
        $categoryes = Category::get();
        return view('create-material')->with(['types' => self::$Types, 'categoryes' => $categoryes]);
    }

    public function addMaterial(Request $request)
    {
        $request->validate([
            'category' => 'required|not_in:0',
            'type' => 'required|not_in:0|in:' . implode(',', self::$Types),
            'name' => 'required',
        ]);

        $data = [
            'name_material' => $request->name,
            'type' => $request->type,
            'fk_id_category' => $request->category,
        ];
        if (!empty($request->description)) {
            $data['description'] = $request->description;
        }
        if (!empty($request->autors)) {
            $data['autors'] = $request->autors;
        }
        Materials::create($data);

        return redirect('materials');
    }

    public function updateMaterial()
    {
        if (isset($_GET['id'])) {
            $material = Materials::where('id_material', $_GET['id'])->first();
            if (!$material) {
                return redirect('/');
            } else {
                $categoryes = Category::get();
                return view('update-material')->with(['types' => self::$Types, 'categoryes' => $categoryes, 'material' => $material]);
            }
        } else {
            return redirect('/');
        }
    }

    public function saveMaterial(Request $request, Materials $material)
    {
        $request->validate([
            'category' => 'required|not_in:0',
            'type' => 'required|not_in:0|in:' . implode(',', self::$Types),
            'name' => 'required',
        ]);

        $material->name_material = $request->input('name');
        if (!empty($request->input('description'))) {
            $material->description = $request->input('description');
        }
        if (!empty($request->input('autors'))) {
            $material->autors = $request->input('autors');
        }
        $material->type = $request->input('type');
        $material->fk_id_category = $request->input('category');
        $material->save();

        return redirect('materials');
    }


    public function deleteMaterial(Materials $material)
    {
        //Удаление всех тегов материала
        $tags_material = Tegs_material::select()->where('fk_id_material', $material->id_material)->get();
        foreach ($tags_material as $tags_material) {
            $tags_material->delete();
        }

        //Удаление всех ссылок материала
        $links = Links::select()->where('fk_id_material', $material->id_material)->get();
        foreach ($links as $link) {
            $link->delete();
        }

        $material->delete();
        return redirect('materials');
    }
}
