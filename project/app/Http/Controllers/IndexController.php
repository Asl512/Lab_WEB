<?php

namespace App\Http\Controllers;
use App\Models\Type;
use App\Models\Tag;
use App\Models\Category;
use App\Models\Materials;
use App\Models\Links;
use App\Models\Tegs_material;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function Search_Materials(Request $request)
    {
        return redirect('materials?search='.$request->search);
    }

    public function Materials()
    {
        $search = '';
        if(isset($_GET['search']))
        {
            $search = $_GET['search'];
            $type = Type::select()->where('name',$search)->first();
            if($type == null)
            {
                $type = -100;
            }
            else
            {
                $type = $type->id; 
            }
            $category = Category::select()->where('name',$search)->first();
            if($category == null)
            {
                $category = -100;
            }
            else
            {
                $category = $category->id; 
            }
            $arr1 = [];
            $mater = Materials::select()->where('name',$search)->orWhere('autors',$search)->orWhere('fk_id_type',$type)->orWhere('fk_id_category',$category)->get();
            for($i=0; $i<count($mater); $i++)
            {
                $arr1[$i] = $mater[$i];
            }

            $arr2 = [];
            $tag = Tag::select()->where('name',$search)->first();
            if($tag != null)
            {
                $tegs_m = Tegs_material::select()->where('fk_id_teg',$tag->id)->get();
                for($i=0; $i<count($tegs_m); $i++)
                {
                    $check = true;
                    $mat = Materials::select()->where('id',$tegs_m[$i]->fk_id_material)->first(); 
                    foreach($arr1 as $ar)
                    {
                        if($mat == $ar)
                        {
                            $check = false;
                        }
                    }
                    if($check == true)
                    {
                        $arr2[$i] = $mat;
                    }
                }
            }
            $materials = array_merge($arr1, $arr2);
        }
        if($search == '')
        {
            $materials = Materials::get();
        }

        foreach($materials as $material)
        {
            $material->fk_id_type = Type::select()->where('id',$material->fk_id_type)->first()->name;
            $material->fk_id_category = Category::select()->where('id',$material->fk_id_category)->first()->name;
        }
        $header = 'Материалы';
        return view('materials')-> with(['header' => $header,'materials'=>$materials,'search'=>$search]);
    }

    public function Save_material(Request $request)
    {
        if(($request->name == '')or($request->type == '-10')or($request->category == '-10'))
        {
            return redirect('create-material?error=1&name='.$request->name.'&autors='.$request->autors.'&description='.$request->description.'&type_id='.$request->type.'&category_id='.$request->category);
        }
        else
        {
            $data = ['name' => $request->name,
                    'fk_id_type' => $request->type,
                    'fk_id_category' => $request->category];
            if($request->description != '')
            {
                $data['description'] = $request->description;
            }
            if($request->autors != '')
            {
                $data['autors'] = $request->autors;
            }
            Materials::create($data);
    
            return redirect('materials');
        }
    }

    public function Update_material(Request $request,$id)
    {
        if(($request->name == '')or($request->type == '-10')or($request->category == '-10'))
        {
            return redirect('create-material?error=2&id='.$id);
        }
        else
        {
            $material = Materials::find($id);
            $material -> name = $request->input('name');
            $material -> autors = $request->input('autors');
            $material -> description = $request->input('description');
            $material -> fk_id_type = $request->input('type');
            $material -> fk_id_category = $request->input('category');
            $material->save();
    
            return redirect('materials');
        }
    }

    public function Add_material()
    {
        $types = Type::get();
        $categoryes = Category::get();
        $name = '';
        $description ='';
        $autors = '';
        $type_id = -10;
        $category_id = -10;
        $id = '';
        $error = 0;

        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
            $material = Materials::select()->where('id',$id)->first();
            $name = $material->name;
            $description = $material->description;
            $autors = $material->autors;
            $type_id = $material->fk_id_type;
            $category_id = $material->fk_id_category;
            $status = 0;
            $header = 'Редактировать материал';
        }
        else
        {
            $status = 1;
            $header = 'Добавить материал';
            if(isset($_GET['name']))
            {
                $name = $_GET['name'];
            }
            if(isset($_GET['type_id']))
            {
                $type_id = $_GET['type_id'];
            }
            if(isset($_GET['autors']))
            {
                $autors = $_GET['autors'];
            }
            if(isset($_GET['category_id']))
            {
                $category_id = $_GET['category_id'];
            }
            if(isset($_GET['description']))
            {
                $description = $_GET['description'];
            }
        }
        if(isset($_GET['error']))
        {
            $error = $_GET['error'];
        }
        
        return view('create-material')-> with(['id'=>$id,'error'=>$error,'description'=>$description,'autors'=>$autors,'name'=>$name,'header' => $header, 'types'=>$types,'categoryes'=>$categoryes,'status'=>$status,'category_id'=>$category_id,'type_id'=>$type_id]);
    }

    public function Delete_Material(Materials $material)
    {
        $tags_material = Tegs_material::select()->where('fk_id_material', $material->id)->get();
        foreach($tags_material as $tags_material)
        {
            $tags_material->delete();
        }
        $links = Links::select()->where('fk_id_material', $material->id)->get();
        foreach($links as $link)
        {
            $link->delete();
        }
        $material->delete();
        return redirect('materials');
    }



    public function Tag()
    {
        $tags = Tag::get();
        $header = 'Теги';
        return view('tag')-> with(['header' => $header,'tags'=>$tags]);
    }

    public function Delete_Tag(Tag $tag)
    {
        $tags_material = Tegs_material::select()->where('fk_id_teg', $tag->id)->get();
        foreach($tags_material as $tags_material)
        {
            $tags_material->delete();
        }
        $tag->delete();
        return redirect('tag');
    }

    public function Save_teg(Request $request)
    {
        if($request->name == '')
        {
            return redirect('create-teg?error=1');
        }
        else
        {
            $teg_check = Tag::select()->where('name',$request->name)->first();
            if($teg_check != null)
            {
                return redirect('create-teg?error=2');
            }
            $data = ['name' => $request->name];
            Tag::create($data);
    
            return redirect('tag');
        }
    }

    public function Update_teg(Request $request,$id)
    {
        if($request->input('name') == '')
        {
            return redirect('create-teg?error=1&id='.$id);
        }
        else
        {
            $teg_check = Tag::select()->where('name',$request->input('name'))->first();
            if($teg_check != null)
            {
                if($teg_check->id != $id)
                {
                    return redirect('create-teg?error=2&id='.$id);
                }
            }
            $teg = Tag::find($id);
            $teg -> name = $request->input('name');
            $teg->save();

            return redirect('tag');
        }
    }

    public function Add_teg()
    {
        $value = '';
        $error = 0;
        $id = '';
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
            $value = Tag::select()->where('id',$id)->first()->name;
            $status = 0;
            $header = 'Редактировать тег';
        }
        else
        {
            $status = 1;
            if(isset($_GET['error']))
            {
                $error = $_GET['error'];
            }
            $header = 'Добавить тег';
        }

        return view('create-teg')-> with(['header' => $header,'error'=>$error,'value'=>$value, 'status'=>$status, 'id'=>$id]);
    }






    public function Category()
    {
        $error = 0;
        $id = null;
        if(isset($_GET['error']))
        {
            $error = $_GET['error'];
            $id = Category::select()->where('id',$_GET['id'])->first();
        }
        $categoryes = Category::get();
        $header = 'Категории';
        return view('category')-> with(['header' => $header, 'categoryes'=>$categoryes,'error'=>$error,'id'=>$id]);
    }

    public function Delete_Category(Category $category)
    {
        if(count(Materials::select()->where('fk_id_category',$category->id)->get()) > 0)
        {
            return redirect('category?error=1&id='.$category->id);
        }
        else
        {
            $category->delete();
            return redirect('category');
        }
    }

    public function Delete_Every_Materials(Category $category)
    {
        $materials = Materials::select()->where('fk_id_category',$category->id)->get();
        foreach($materials as $material)
        {
            $tags_material = Tegs_material::select()->where('fk_id_material', $material->id)->get();
            foreach($tags_material as $tags_material)
            {
                $tags_material->delete();
            }
            $links = Links::select()->where('fk_id_material', $material->id)->get();
            foreach($links as $link)
            {
                $link->delete();
            }
            $material->delete();
        }
        $category->delete();
        return redirect('category');
    }

    public function Save_category(Request $request)
    {
        if($request->name == '')
        {
            return redirect('create-category?error=1');
        }
        else
        {
            $category_check = Category::select()->where('name',$request->name)->first();
            if($category_check != null)
            {
                return redirect('create-category?error=2');
            }
            $data = ['name' => $request->name];
            Category::create($data);
    
            return redirect('category');
        }
    }

    public function Update_category(Request $request,$id)
    {
        if($request->input('name') == '')
        {
            return redirect('create-category?error=1&id='.$id);
        }
        else
        {
            $category_check = Category::select()->where('name',$request->input('name'))->first();
            if($category_check != null)
            {
                if($category_check->id != $id)
                {
                    return redirect('create-category?error=2&id='.$id);
                }
            }
            $category = Category::find($id);
            $category -> name = $request->input('name');
            $category->save();

            return redirect('category');
        }
    }

    public function Add_category()
    {
        $value = '';
        $error = 0;
        $id = '';
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
            $value = Category::select()->where('id',$id)->first()->name;
            $status = 0;
            $header = 'Редактировать категорию';
        }
        else
        {
            $status = 1;
            if(isset($_GET['error']))
            {
                $error = $_GET['error'];
            }
            $header = 'Добавить категорию';
        }

        return view('create-category')-> with(['header' => $header,'error'=>$error,'value'=>$value, 'status'=>$status, 'id'=>$id]);
    }

    public function View()
    {
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
            $material = Materials::select()->where('id',$id)->first();
            if($material == null)
            {
                return redirect('/');
            }
            else
            {
                $error = 0;
                if(isset($_GET['error']))
                {
                    $error = $_GET['error'];
                }
                $material->fk_id_type = Type::select()->where('id',$material->fk_id_type)->first()->name;
                $material->fk_id_category = Category::select()->where('id',$material->fk_id_category)->first()->name;
                $header = $material->name;
                $tags = Tag::get();
                $tags_material = Tegs_material::select()->where('fk_id_material',$material->id)->get();
                $links = Links::select()->where('fk_id_material',$material->id)->get();
                foreach($tags_material as $tag)
                {
                    $tag->name = Tag::select()->where('id',$tag->fk_id_teg)->first()->name;
                }
                return view('view-material')-> with(['header' => $header,'links'=>$links,'material'=>$material,'tags'=>$tags,'tags_material'=>$tags_material,'error'=>$error]);
            }
        }
        else
        {
            return redirect('/');
        }
    }

    public function Add_tag_material(Request $request, $id)
    {
        $tags = Tegs_material::select()->where('fk_id_material',$id)->get();
        foreach($tags as $tag)
        {
            if($tag->fk_id_teg == $request->teg)
            {
                return redirect('view-material?error=1&id='.$id);
            }
        }
        $data = ['fk_id_teg' => $request->teg,
                'fk_id_material' => $id];
        Tegs_material::create($data);
    
        return redirect('view-material?id='.$id);
    }

    public function Delete_Tag_Material(Tegs_material $id)
    {
        $id->delete();
        return redirect('view-material?id='.$id->fk_id_material);
    }

    public function Delete_Link_Material(Links $id)
    {
        $id->delete();
        return redirect('view-material?id='.$id->fk_id_material);
    }

    public function Save_link(Request $request,$id)
    {
        if(($request->name != '')or($request->link != ''))
        {
            $data = ['name' => $request->name,
                    'link' => $request->link,
                    'fk_id_material' => $id];
            Links::create($data);
        }
        return redirect('view-material?id='.$id);
    }
}
