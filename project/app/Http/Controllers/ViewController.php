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
    public function View()
    {
        if(isset($_GET['id']))
        {
            $material = Materials::select()->where('id_material',$_GET['id'])->join('category', 'material.fk_id_category', '=', 'category.id_category')->first();
            if(!$material)
            {
                return redirect('/');
            }
            else
            {
                $tags =Tag::get();
                $tags_material = Tag::join('tegs_material','teg.id_teg','=','tegs_material.fk_id_teg')->where('tegs_material.fk_id_material',$material->id_material)->get();
                $links = Links::select()->where('fk_id_material',$material->id_material)->get();

                return view('view-material')-> with(['links'=>$links,'material'=>$material,'tags_material'=>$tags_material,'tags'=>$tags,]);
            }
        }
        else
        {
            return redirect('/');
        }
    }

    public function AddTagMaterial(Request $request, $id)
    {
        $request->validate(['tag' => ['required','not_in:0',Rule::unique('tegs_material','fk_id_teg')->where('fk_id_material',$id)]]);

        $data = ['fk_id_teg' => $request->tag,
                'fk_id_material' => $id];
        Tegs_material::create($data);
    
        return redirect('view-material?id='.$id);
    }

    public function DeleteTagMaterial(Tegs_material $id)
    {
        $id->delete();
        return redirect('view-material?id='.$id->fk_id_material);
    }


    public function CreateLink()
    {
        if(isset($_GET['id']))
        {
            $material = Materials::where('id_material',$_GET['id'])->first();
            if(!$material)
            {
                return redirect('/');
            }
            else
            {
                return view('create-link')->with(['material'=>$material]);
            }
        }
        else
        {
            return redirect('/');
        }
    }

    public function Addlink(Request $request,$id)
    {
        $request->validate(['link' => ['required',Rule::unique('links','link')->where('fk_id_material',$id)]]);

        $data = ['link' => $request->link,
                'fk_id_material' => $id];
        if($request->name != '')
        {
            $data['name_link'] = $request->name;
        }
        Links::create($data);

        return redirect('view-material?id='.$id);
    }

    public function UpdateLink()
    {
        if(isset($_GET['id']))
        {
            $link = Links::where('id_link',$_GET['id'])->first();
            if(!$link)
            {
                return redirect('/');
            }
            else
            {
                return view('update-link')->with(['link'=>$link]);
            }
        }
        else
        {
            return redirect('/');
        }
    }

    public function SaveLink(Request $request,Links $link)
    {
        $request->validate(['link' => ['required',Rule::unique('links','link')->where('fk_id_material',$link->fk_id_material)->ignore($link->id_link,'id_link')]]);
        
        if($request->input('name') != '')
        {
            $link -> name_link = $request->input('name');
        }
        $link -> link = $request->input('link');
        $link->save();

        return redirect('view-material?id='.$link->fk_id_material);
    }

    public function DeleteLinkMaterial(Links $id)
    {
        $id->delete();
        return redirect('view-material?id='.$id->fk_id_material);
    }
}
