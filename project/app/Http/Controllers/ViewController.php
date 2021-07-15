<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Materials;
use App\Models\Links;
use App\Models\Tegs_material;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ViewController extends Controller
{
    public function view()
    {
        if (isset($_GET['id'])) {
            $material = Materials::where('id_material', $_GET['id'])->join('category', 'material.fk_id_category', '=', 'category.id_category')->first();
            if (!$material) {
                return redirect('/');
            } else {
                $tags = Tag::get();
                $tags_material = Tag::join('tegs_material', 'teg.id_teg', '=', 'tegs_material.fk_id_teg')->where('tegs_material.fk_id_material', $material->id_material)->get();
                $links = Links::select()->where('fk_id_material', $material->id_material)->get();

                return view('view-material')->with(['links' => $links, 'material' => $material, 'tags_material' => $tags_material, 'tags' => $tags,]);
            }
        } else {
            return redirect('/');
        }
    }

    public function addTagMaterial(Request $request, $id_material)
    {
        $request->validate(['tag' => ['required', 'not_in:0', Rule::unique('tegs_material', 'fk_id_teg')->where('fk_id_material', $id_material)]]);

        $data = [
            'fk_id_teg' => $request->tag,
            'fk_id_material' => $id_material
        ];
        Tegs_material::create($data);

        return redirect('view-material?id=' . $id_material);
    }

    public function deleteTagMaterial(Tegs_material $tag_material)
    {
        $tag_material->delete();
        return redirect('view-material?id=' . $tag_material->fk_id_material);
    }

    public function addlink(Request $request, $id_material)
    {
        $request->validate(['link' => ['required', Rule::unique('links', 'link')->where('fk_id_material', $id_material)]]);

        $data = [
            'link' => $request->link,
            'fk_id_material' => $id_material
        ];
        if (!empty($request->name)) {
            $data['name_link'] = $request->name;
        }
        Links::create($data);

        return redirect('view-material?id=' . $id_material);
    }

    public function saveLink(Request $request, Links $link)
    {
        $request->validate(['link' => ['required', Rule::unique('links', 'link')->where('fk_id_material', $link->fk_id_material)->ignore($link->id_link, 'id_link')]]);

        if (!empty($request->input('name'))) {
            $link->name_link = $request->input('name');
        }
        $link->link = $request->input('link');
        $link->save();

        return redirect('view-material?id=' . $link->fk_id_material);
    }

    public function deleteLinkMaterial(Links $link)
    {
        $link->delete();
        return redirect('view-material?id=' . $link->fk_id_material);
    }
}
