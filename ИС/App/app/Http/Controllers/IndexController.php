<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Bascket;
use App\Models\Order;
use App\Models\Suppli;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use function Symfony\Component\VarDumper\Dumper\esc;

class IndexController extends Controller
{
    public function Index()
    {
        $header = 'Главная';
        $products = Products::select()->get();
        $error = 0;
        if(isset($_GET['error']))
        {
            $error = $_GET['error'];
        }
        return view('index')->with(['header'=>$header,'products'=>$products,'error'=>$error]);
    }



    public function Order()
    {
        if(Auth::check())
        {
            if(Auth::user()->status == 0)
            {
                $header = 'Корзина';
                $id_products = Bascket::select()->get();
                $products = array();
                for($i=0;$i<count($id_products);$i++)
                {
                    $products[$i] = Products::select()->where('id',$id_products[$i]->fk_id_product)->first();
                }
                $error = 0;
                $name_in_error = '';
                $id_last_order = Order::select()->get();
                $numb = $id_last_order[count($id_last_order)-1]->name_order[1]+1;
                $name_order_value = $id_last_order[count($id_last_order)-1]->name_order[0].''.$numb;
                if(isset($_GET['error']))
                {
                    $error = $_GET['error'];
                }

                if(isset($_GET['name_in_error']))
                {
                    $name_in_error = $_GET['name_in_error'];
                }

                return view('order')->with(['header'=>$header,'products'=>$products,'error'=>$error,'name_order_value'=>$name_order_value,'name_in_error'=>$name_in_error]);
            }
            else
            {
                return redirect('index');
            }
        }
        else
        {
            return redirect('index');
        }
    }


    public function Suppli()
    {
        if(Auth::check())
        {
            if(Auth::user()->status == 2)
            {
                $header = 'Составить поставку';
                $products = Products::select()->get();
                $error = 0;
                $name_in_error = '';
                $name_suppli_value = '';
                if(isset($_GET['error']))
                {
                    $error = $_GET['error'];
                }

                if(isset($_GET['name_in_error']))
                {
                    $name_in_error = $_GET['name_in_error'];
                }
                
                if(isset($_GET['name_suppli_value']))
                {
                    $name_suppli_value = $_GET['name_suppli_value'];
                }

                return view('suppli')->with(['header'=>$header,'products'=>$products,'error'=>$error,'name_suppli_value'=>$name_suppli_value,'name_in_error'=>$name_in_error]);
            }
            else
            {
                return redirect('index');
            }
        }
        else
        {
            return redirect('index');
        }
    }


    public function AddSuppli(Request $request)
    {    
        if($request->name_suppli_value == '')
        {
            return redirect('/suppli?error=4');
        }
        else
        {
            $check_suppli = Suppli::select()->get();
            foreach($check_suppli as $suppli)
            {
                if($request->name_suppli_value == $suppli->name_suppli)
                {
                    return redirect('/suppli?error=5');
                }
            }

            $count_zero = 0;
            for($i = 1; $i <= count(Products::select()->get()); $i++)
            {
                $per_count = 'count_'.$i;

                if($request->$per_count <= 0)
                {
                    $count_zero++;
                }
            }

            if($count_zero == 3)
            {
                return redirect('/suppli?error=1&name_suppli_value='.$request->name_suppli_value);
            }
            else
            {
                for($i = 1; $i <= count(Products::select()->get()); $i++)
                {
                    $per_count = 'count_'.$i;
                    if($request->$per_count > 0)
                    {
                        $per_name = 'name_'.$i;
                        $product_one = Products::select()->where('name',$request->$per_name)->first();


                        $suppli = Products::find($product_one->id);
                        $suppli -> count = $suppli->count + $request->input($per_count);
                        $suppli->save();

                        $data = ['name_suppli'=>$request->name_suppli_value,
                        'fk_id_product'=>$product_one->id,
                        'count'=>$request->$per_count,
                        'fk_id_supplier'=>Auth::id()];
                        Suppli::create($data);
                    
                    }
                }
                return redirect('/mysuppli');
            }
        }
    }

    public function AddOrders(Request $request)
    {  
        $basket = Bascket::select()->get();
        foreach($basket as $basc)
        {
            $per_count = 'count_'.$basc->fk_id_product;

            $per_name = 'name_'.$basc->fk_id_product;
            $product_one = Products::select()->where('name',$request->$per_name)->first();

            if($product_one->count == 0)
            {
                return redirect('order?error=3&name_in_error='.$request->$per_name.'&name_order='.$request->name_order);
            }
            elseif($product_one->count < $request->$per_count)
            {
                return redirect('order?error=1&name_in_error='.$request->$per_name.'&name_order='.$request->name_order);
            }
            else
            {
                $data = ['name_order'=>$request->name_order,
                        'fk_id_product'=>$basc->fk_id_product,
                        'count'=>$request->$per_count,
                        'fk_id_shop'=>Auth::id(),
                        'fk_id_staff'=>0,
                        'status'=>0];
                Order::create($data);

                Bascket::truncate();
            }
        }
        return redirect('/myorder');
    }



    public function Myorder()
    {
        if(Auth::check())
        {
            if(Auth::user()->status == 0)
            {
                $header = 'Заявки '.Auth::user()->name;
                $orders = Order::select()->where('fk_id_shop',Auth::id())->get();

                $orders_over_name = array();
                $count_NON = 0;
                $check_order = array();
                for($i=0; $i<count($orders); $i++)
                {
                    $check = true;
                    for($j=0; $j<count($orders_over_name); $j++)
                    {
                        if($orders_over_name[$j] == $orders[$i]->name_order)
                        {
                            $check = false;
                        }
                    }
                    if($check == true)
                    {
                        $orders_over_name[$count_NON] = $orders[$i]->name_order;
                        $check_order[$count_NON] = Order::select()->where('name_order',$orders_over_name[$count_NON])->first()->status;
                        $count_NON++;
                    }
                } 

                $needs_orders = array();
                for($i=0; $i<count($orders_over_name); $i++)
                {
                    $needs_orders[$i] = Order::select()->where('name_order',$orders_over_name[$i])->get();
                }
                
                $products = array();
                for($i=0; $i<count($orders_over_name); $i++)
                {
                    for($j=0; $j<count($needs_orders[$i]); $j++)
                    {
                        $products[$i][$j] = Products::select()->where('id',$needs_orders[$i][$j]->fk_id_product)->first();
                    }
                }

                return view('myorder')->with(['check_order'=>$check_order,'header'=>$header,'needs_orders'=>$needs_orders,'orders_over_name'=>$orders_over_name,'products'=>$products]);
            }
            else
            {
                return redirect('index');
            }
        }
        else
        {
            return redirect('index');
        }
    }



    public function Mysuppli()
    {
        if(Auth::check())
        {
            if(Auth::user()->status == 2)
            {
                $header = 'Мои накладные';
                $suppli = Suppli::select()->where('fk_id_supplier',Auth::id())->get();

                $suppli_over_name = array();
                $count_NON = 0;
                for($i=0; $i<count($suppli); $i++)
                {
                    $check = true;
                    for($j=0; $j<count($suppli_over_name); $j++)
                    {
                        if($suppli_over_name[$j] == $suppli[$i]->name_suppli)
                        {
                            $check = false;
                        }
                    }
                    if($check == true)
                    {
                        $suppli_over_name[$count_NON] = $suppli[$i]->name_suppli;
                        $count_NON++;
                    }
                } 

                $needs_suppli = array();
                for($i=0; $i<count($suppli_over_name); $i++)
                {
                    $needs_suppli[$i] = Suppli::select()->where('name_suppli',$suppli_over_name[$i])->get();
                }
                
                $products = array();
                for($i=0; $i<count($suppli_over_name); $i++)
                {
                    for($j=0; $j<count($needs_suppli[$i]); $j++)
                    {
                        $products[$i][$j] = Products::select()->where('id',$needs_suppli[$i][$j]->fk_id_product)->first();
                    }
                }

                return view('mysuppli')->with(['header'=>$header,'needs_suppli'=>$needs_suppli,'suppli_over_name'=>$suppli_over_name,'products'=>$products]);
            }
            else
            {
                return redirect('index');
            }
        }
        else
        {
            return redirect('index');
        }
    }




    public function UpdateOrder()
    {
        if(Auth::check())
        {
            if((Auth::user()->status == 0)and(isset($_GET['name'])))
            {
                $name_order_value = $_GET['name'];
                $header = 'Редактировать заказ';
                $orders = Order::select()->where('name_order',$name_order_value)->get();
                    $products = array();
                    for($i=0;$i<count($orders);$i++)
                    {
                        $products[$i] = Products::select()->where('id',$orders[$i]->fk_id_product)->first();
                    }
                    $error = 0;
                    if(isset($_GET['error']))
                    {
                        $error = $_GET['error'];
                    }

                    return view('updateorder')->with(['header'=>$header,'name_order_value'=>$name_order_value,'orders'=>$orders,'products'=>$products,'error'=>$error]);

            }
            else
            {
                return redirect('index');
            }
        }
        else
        {
            return redirect('index');
        }
    }


    public function DeleteOrder($order)
    {
        $orders = Order::select()->where('name_order',$order)->get();

        foreach($orders as $order)
        {
            $order->delete();
        }
        return redirect('/myorder');
    }

    public function DeleteStaff(User $user)
    {
        $user->delete();
        return redirect('/staff');
    }

    public function SaveOrder(Request $request)
    {
        $name = $_GET['name'];
        $orders = Order::select()->where('name_order',$name)->get();

        for($i=0;$i<count($orders);$i++)
        {
            $per_count = 'count_'.$orders[$i]->id;
            if($request->input($per_count) <= 0)
            {
                return redirect('updateorder?name='.$name.'&error=1');
            }
            else
            {
                $order = Order::find($orders[$i]->id);
                $order -> count = $request->input($per_count);
                $order->save();
            }
        }

        return redirect('/myorder');
    }


    public function Product()
    {
        if(Auth::check())
        {
            if((Auth::user()->status == 1)||(Auth::user()->status == 3))
            {
                $header = 'Добавить товар';
                $path = "C:/OpenServer/domains/localhost/IS/public/images";
                $images = array();
                                    
                if($handle = opendir($path))
                {
                    $count = 0;
                    while($entry = readdir($handle))
                    {
                        $count++;
                        if($count > 2)
                        {
                            $images[$count-3] = $entry;
                        }
                    }     
                    closedir($handle);
                }
                $name_value = '';
                $count_value = 0;
                $description_value = '';
                $error = 0;
                $img_value = '';
                $date_value = date('Y-m-d');
                $price_value = 0;
                if(isset($_GET['error']))
                {
                    $name_value = $_GET['name'];
                    $count_value = $_GET['count'];
                    $description_value = $_GET['description'];
                    $img_value = $_GET['img'];
                    $date_value = $_GET['year'];
                    $price_value = $_GET['prace'];
                    $error = $_GET['error'];
                }

                return view('product')->with(['header'=>$header,'images'=>$images,'name_value'=>$name_value,'count_value'=>$count_value,'description_value'=>$description_value,
                'error'=>$error,'img_value'=>$img_value,'date_value'=>$date_value,'price_value'=>$price_value]);
            }
             else
            {
                return redirect('index');
            }
        }
        else
        {
            return redirect('index');
        }
    }



    public function AddProduct(Request $request)
    {
        $this->validate($request,['name' => 'required',
                                'img' => 'required',
                                'description' => 'required',
                                'year_proiz' => 'required',
                                'prace' => 'required']);
        
        $products = Products::select()->get();
        foreach ($products as $product)
        {
            if($request->name == $product->name)
            {
                return redirect('/product?error=1&img='.$request->img.'&name='.$request->name.'&description='.$request->description.'&year='.$request->year_proiz.'&prace='.$request->prace);
            }
        }

        if($request->year_proiz < date('Y-m-d'))
        {
            return redirect('/product?error=2&img='.$request->img.'&name='.$request->name.'&description='.$request->description.'&year='.$request->year_proiz.'&prace='.$request->prace);
        }
        else
        {
            $year = $request->year_proiz;
            $date_mas = str_split($year,4);
            $data = ['name' => $request->name,
                    'img' => $request->img,
                    'description' => $request->description,
                    'year_proiz' => $date_mas[0],
                    'prace' => $request->prace];

            Products::create($data);

            return redirect('/index');
        }
    }



    public function DeleteProduct(Products $product)
    {
        $check = Order::select()->where('fk_id_product',$product->id)->get();

        //добавить проверку у поставщиков

        if(count($check) == 0)
        {
            $product->delete();
            return redirect('/index');
        }
        else
        {
            return redirect('/index?error=2');
        }
    }



    public function UpdateProduct()
    {
        if(Auth::check())
        {
            if(Auth::user()->status == 1)
            {
                $id = $_GET['id'];
                $header = 'Редактировать товар';
                $error = 0;
                if(isset($_GET['error']))
                {
                    $error = $_GET['error'];
                }
                $path = "C:/OpenServer/domains/localhost/IS/public/images";
                $images = array();
                                    
                if($handle = opendir($path))
                {
                    $count = 0;
                    while($entry = readdir($handle))
                    {
                        $count++;
                        if($count > 2)
                        {
                            $images[$count-3] = $entry;
                        }
                    }     
                    closedir($handle);
                }
                $product = Products::select()->where('id',$id)->first();
                return view('updateproduct')->with(['header'=>$header,'product'=>$product,'error'=>$error,'images'=>$images]);
            }
            else
            {
                return redirect('/index');   
            }
        }
        else
        {
            return redirect('/index'); 
        }
    }



    public function SaveProduct(Request $request)
    {
        $id = $_GET['id'];
        if(($request->input('name') == '')||($request->input('description') == ''))
        {
            return redirect('/updateproduct?error=1&id='.$id); 
        }
        elseif($request->input('prace') <= 0)
        {
            return redirect('/updateproduct?error=2&id='.$id); 
        }
        elseif(($request->input('year_proiz')<1979)||($request->input('year_proiz')>2021))
        {
            return redirect('/updateproduct?error=3&id='.$id); 
        }
        else
        {
            $products = Products::select()->get();
            foreach($products as $product)
            {
                if($id != $product->id)
                {
                    if($request->input('name') == $product->name)
                    {
                        return redirect('/updateproduct?error=4&id='.$id); 
                    }
                }
            }
            $product = Products::find($id);
            $product -> name = $request->input('name');
            $product -> img = $request->input('img');
            $product -> description = $request->input('description');
            $product -> year_proiz = $request->input('year_proiz');
            $product -> prace = $request->input('prace');
            $product -> count = $request->input('count');
            $product->save();

            return redirect('/index');
        }
    }

    public function Staff()
    {
        if(Auth::check())
        {
            if(Auth::user()->status == 1)
            {
                $header = 'Сотрудники';
                $users = User::select()->where('status',3)->get();
                $error = 0;
                $name = '';
                $email = '';
                if(isset($_GET['error']))
                {
                    $error = $_GET['error'];
                    $name = $_GET['name'];
                    $email = $_GET['email'];
                }

                return view('staff')->with(['header'=>$header,'users'=>$users,'error'=>$error,'name'=>$name,'email'=>$email]);
            }
            else
            {
                return redirect('index');
            }
        }
        else
        {
            return redirect('index');
        }
    }



    public function AddStaff(Request $request)
    {
        if(($request->name = '')||($request->email == '')||($request->password == ''))
        {
            return redirect('staff?error=1&name='.$request->name.'&email='.$request->email);
        }
        else
        {
            $users = User::select()->get();
            foreach($users as $user)
            {
                if($user->email == $request->email)
                {
                    return redirect('staff?error=2&name='.$request->name.'&email='.$request->email);
                }
            }
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => 3
                    ]);
    
                return redirect('/staff');
        }
    }



    public function Everyorder()
    {
        if(Auth::check())
        {
            if(Auth::user()->status == 3)
            {
                $header = 'Все записи';
                $everyorders = Order::select()->get();
                $orders = array();
                $count_o = 0;
                foreach($everyorders as $everyorder)
                {
                    if(($everyorder->status != 3)and($everyorder->status != 2))
                    {
                        $orders[$count_o] = $everyorder;
                        $count_o++;
                    }
                }


                $orders_over_name = array();
                $check_order = array();
                $count_NON = 0;
                for($i=0; $i<count($orders); $i++)
                {
                    $check = true;
                    for($j=0; $j<count($orders_over_name); $j++)
                    {
                        if($orders_over_name[$j] == $orders[$i]->name_order)
                        {
                            $check = false;
                        }
                    }
                    if($check == true)
                    {
                        $orders_over_name[$count_NON] = $orders[$i]->name_order;
                        $check_order[$count_NON] = Order::select()->where('name_order',$orders_over_name[$count_NON])->first()->status;
                        $count_NON++;
                    }
                } 

                $needs_orders = array();
                for($i=0; $i<count($orders_over_name); $i++)
                {
                    $needs_orders[$i] = Order::select()->where('name_order',$orders_over_name[$i])->get();
                }
                
                $products = array();
                $shops = array();
                for($i=0; $i<count($orders_over_name); $i++)
                {
                    for($j=0; $j<count($needs_orders[$i]); $j++)
                    {
                        $products[$i][$j] = Products::select()->where('id',$needs_orders[$i][$j]->fk_id_product)->first();
                        $shops[$i] = User::select()->where('id',$needs_orders[$i][$j]->fk_id_shop)->first();
                    }
                }

                return view('everyorder')->with(['check_order'=>$check_order,'header'=>$header,'needs_orders'=>$needs_orders,'orders_over_name'=>$orders_over_name,'products'=>$products,'shops'=>$shops]);
            }
            else
            {
                return redirect('index');
            }
        }
        else
        {
            return redirect('index');
        }
    }

    public function AddStaffOrder()
    {
        $name = $_GET['name'];
        $orders = Order::select()->where('name_order',$name)->get();

        foreach($orders as $order)
        {
            $order = Order::find($order->id);
            $order->fk_id_staff = Auth::id();
            $order->status = 1;
            $order->save();
        }

        return redirect('/everyorder');
    }


    public function Myorderstaff()
    {
        if(Auth::check())
        {
            if(Auth::user()->status == 3)
            {
                $header = 'Взятые заказы';
                $orders = Order::select()->where('fk_id_staff',Auth::id())->get();

                $orders_over_name = array();
                $count_NON = 0;
                for($i=0; $i<count($orders); $i++)
                {
                    $check = true;
                    for($j=0; $j<count($orders_over_name); $j++)
                    {
                        if($orders_over_name[$j] == $orders[$i]->name_order)
                        {
                            $check = false;
                        }
                    }
                    if($check == true)
                    {
                        $orders_over_name[$count_NON] = $orders[$i]->name_order;
                        $count_NON++;
                    }
                } 

                $needs_orders = array();
                for($i=0; $i<count($orders_over_name); $i++)
                {
                    $needs_orders[$i] = Order::select()->where('name_order',$orders_over_name[$i])->get();
                }
                
                $products = array();
                for($i=0; $i<count($orders_over_name); $i++)
                {
                    for($j=0; $j<count($needs_orders[$i]); $j++)
                    {
                        $products[$i][$j] = Products::select()->where('id',$needs_orders[$i][$j]->fk_id_product)->first();
                    }
                }

                return view('myorderstaff')->with(['header'=>$header,'needs_orders'=>$needs_orders,'orders_over_name'=>$orders_over_name,'products'=>$products]);
            }
            else
            {
                return redirect('index');
            }
        }
        else
        {
            return redirect('index');
        }
    }


    public function MyorderstaffAdd()
    {
        $name = $_GET['name'];
        $orders = Order::select()->where('name_order',$name)->get();

        foreach($orders as $order)
        {
            $order = Order::find($order->id);
            $order->fk_id_staff = 0;
            $order->status = 2;
            $order->save();

            $product = Products::find($order->fk_id_product);
            $product->count = $product->count - $order->count;
            $product->save();
        }

        return redirect('/myorderstaff');
    }

    public function Oplatit()
    {
        $name = $_GET['name'];
        $orders = Order::select()->where('name_order',$name)->get();

        foreach($orders as $order)
        {
            $order = Order::find($order->id);
            $order->fk_id_staff = 0;
            $order->status = 3;
            $order->save();
        }

        return redirect('/myorder');
    }

    public function Bascket($product)
    {
        $bascket = Bascket::select()->get();
        foreach($bascket as $bas)
        {
            if($bas->fk_id_product == $product)
            {
                return redirect('/index');
            }
        }
        Bascket::create(['fk_id_product' => $product]);
        return redirect('/index');
    }

    public function DeleteBascket($product)
    {
        $basck = Bascket::select()->where('fk_id_product',$product)->first();
        $basck->delete();
        return redirect('/order');
    }


    public function Reports()
    {
        if(Auth::check())
        {
            if(Auth::user()->status == 3)
            {
                $error = 0;
                if(isset($_GET['error']))
                {
                    $error = $_GET['error'];
                }  
                $header = 'Отчеты';
                $months = ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'];
                $numb_month = [0,1,2,3,4,5,6,7,8,9,10,11];

                $users = User::select()->where('status','3')->get();

                $orders = array();
                for($i = 0; $i < count($users); $i++)
                {
                    $orders[$i] = Order::select()->where('fk_id_staff',$users[$i]->id)->where('status','3')->get();
                } 

                $name_ord = array();
                for($i = 0; $i < count($users); $i++)
                {
                    $name_ord[$i] = [];
                    $count_check = 0;
                    for($j = 0; $j < count($orders[$i]); $j++)
                    {
                        $check = true;
                        for($k = 0; $k < count($name_ord[$i]); $k++)
                        {
                            if($name_ord[$i][$k] == $orders[$i][$j]->name_order)
                            {
                                $check = false;
                            }
                        }
                        if($check == true)
                        {
                            $name_ord[$i][$count_check] = $orders[$i][$j]->name_order;
                            $count_check++;
                        }
                    }
                }

                $numb_ord = array();
                for($i = 0; $i < count($users); $i++)
                {
                    $numb_ord[$i] = count($name_ord[$i]); 
                }

                return view('reports')->with(["header"=>$header,'months'=>$months,'numb_month'=>$numb_month,'error'=>$error,'users'=>$users,'numb_ord'=>$numb_ord]);
            }
            else
            {
                return redirect('index');
            }
        }
        else
        {
            return redirect('index');
        }
    }

    public function POSTsale(Request $request)
    {
        if($request->from > $request->befor)
        {
            return redirect('reports?error=1');
        }
        return redirect('sale?from='.$request->from.'&befor='.$request->befor);
    }

    public function Sale()
    {
        if(Auth::check())
        {
            if(Auth::user()->status == 3)
            {
                if(isset($_GET['from']))
                {
                    $from = $_GET['from'];
                    if((isset($_GET['befor']))||($from > $_GET['befor']))
                    {
                        $befor = $_GET['befor'];
                        $header = 'Отчет по продажам за '.$from.' - '.$befor;
                        
                        $orders = Order::select()->where('status','3')->get();
                        $orders_moth = array();
                        $created = array();
                        $readed = array();
                        $count_OM = 0;
                        foreach($orders as $order)
                        {
                            if(($order->updated_at > $from)and($order->updated_at < $befor))
                            {
                                $orders_moth[$count_OM] = $order;
                                $count_OM++;
                            }
                        }

                        $orders_over_name = array();
                        $count_NON = 0;
                        for($i=0; $i<count($orders_moth); $i++)
                        {
                            $check = true;
                            for($j=0; $j<count($orders_over_name); $j++)
                            {
                                if($orders_over_name[$j] == $orders_moth[$i]->name_order)
                                {
                                    $check = false;
                                }
                            }
                            if($check == true)
                            {
                                $orders_over_name[$count_NON] = $orders_moth[$i]->name_order;
                                $date_time = explode(" ", $orders_moth[$i]->created_at);
                                $created[$count_NON] = $date_time[0];
                                $date_time2 = explode(" ", $orders_moth[$i]->updated_at);
                                $readed[$count_NON] = $date_time2[0];
                                $count_NON++;
                            }
                        } 

                        $needs_orders = array();
                        for($i=0; $i<count($orders_over_name); $i++)
                        {
                            $needs_orders[$i] = Order::select()->where('name_order',$orders_over_name[$i])->get();
                        }
                
                        $products = array();
                        for($i=0; $i<count($orders_over_name); $i++)
                        {
                            for($j=0; $j<count($needs_orders[$i]); $j++)
                            {
                                $products[$i][$j] = Products::select()->where('id',$needs_orders[$i][$j]->fk_id_product)->first();
                            }
                        }


                        return view('sale')->with(['readed'=>$readed,'created'=>$created,'header'=>$header,'products'=>$products,'needs_orders'=>$needs_orders,'orders_over_name'=>$orders_over_name]);
                    }
                    else
                    {
                        return redirect('index');
                    }
                }   
                else
                {
                    return redirect('index');
                }
            }
            else
            {
                return redirect('index');
            }
        }
        else
        {
            return redirect('index');
        }
    }
}