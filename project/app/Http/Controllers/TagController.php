<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Tegs_material;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function tag()
    {
        $tags = Tag::get();
        return view('tag')->with(['tags' => $tags]);
    }

    public function deleteTag(Tag $tag)
    {
        //удаляет данный тег во всех материалах
        $tags_material = Tegs_material::select()->where('fk_id_teg', $tag->id_teg)->get();
        foreach ($tags_material as $tags_material) {
            $tags_material->delete();
        }

        $tag->delete();

        return redirect('tag');
    }

    public function createTag(Request $request)
    {
        $request->validate(['name' => 'required|unique:teg,name_teg']);

        $data = ['name_teg' => $request->name];
        Tag::create($data);

        return redirect('tag');
    }

    public function updateTag()
    {
        if (isset($_GET['id'])) {
            $tag = Tag::select()->where('id_teg', $_GET['id'])->first();
            if (!$tag) {
                return redirect('tag');
            } else {
                return view('update-teg')->with(['tag' => $tag]);
            }
        } else {
            return redirect('tag');
        }
    }

    public function saveTag(Request $request, Tag $tag)
    {
        $request->validate(['name' => 'required|unique:teg,name_teg,' . $tag->id_teg . ',id_teg']);

        $tag->name_teg = $request->input('name');
        $tag->save();

        return redirect('tag');
    }
}
