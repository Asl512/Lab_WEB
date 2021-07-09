<?php

namespace App\Http\Controllers;
use App\Models\Tag;
use App\Models\Tegs_material;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function Tag()
    {
        $tags = Tag::get();
        return view('tag')-> with(['tags'=>$tags]);
    }

    public function Delete_Tag(Tag $tag)
    {
        $tags_material = Tegs_material::select()->where('fk_id_teg', $tag->id_teg)->get();
        foreach($tags_material as $tags_material)//удаляет данный тег во всех материалах
        {
            $tags_material->delete();
        }

        $tag->delete();
        
        return redirect('tag');
    }

    public function CreateTag(Request $request)
    {
        $request->validate(['name' => 'required|unique:teg,name_teg']);

        $data = ['name_teg' => $request->name];
        Tag::create($data);

        return redirect('tag');
    }

    public function UpdateTag()
    {
        if(isset($_GET['id']))
        {
            $tag = Tag::select()->where('id_teg',$_GET['id'])->first();
            if(!$tag)
            {
                return redirect('tag');
            }
            else
            {
                return view('update-teg')-> with(['tag'=>$tag]);
            }
        }
        else
        {
            return redirect('tag');
        }
    }

    public function SaveTag(Request $request,$id)
    {
        $request->validate(['name' => 'required|unique:teg,name_teg,'.$id.',id_teg']);

        $teg = Tag::find($id);
        $teg -> name_teg = $request->input('name');
        $teg->save();

        return redirect('tag');
    }
}
