@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                @if(count($orders_over_name) == 0)
                    <div class="card">
                        <div class="card-header">У вас пока нет записей</div>
                    </div>
                @else
                    @for($i = 0; $i < count($orders_over_name);$i++)
                    @if($needs_orders[$i][0]->status != 3)
                    <div class="card">
                        <div class="card-header"><h2>{{ $orders_over_name[$i] }}</h2></div>
                            <div class="card-body">
                                <div class="flex-center position-ref full-height">
                                @for($j = 0; $j < count($needs_orders[$i]); $j++)
                                    <div class = 'contentCard' style='border:1px solid rgba(0, 0, 0, 0.2);; padding: 10px 10px 10px 10px'>
                                        <p class = 'content'><b>{{$products[$i][$j]->name}}</b></p>
                                        <p>Вы заказали: {{$needs_orders[$i][$j]->count}} шт.</p>
                                            @if($needs_orders[$i][$j]->status == 0)
                                                <p>Статус:<br> В ожидании</br></p>
                                            @elseif($needs_orders[$i][$j]->status == 1)
                                                <p>Статус:<br> В обработке</br></p>
                                            @elseif($needs_orders[$i][$j]->status == 2)
                                                <p>Статус:<br>Готов</br></p>
                                            @endif
                                    </div><br>
                                @endfor
                                </div>

                                <?php
                                $price = 0;
                                    for($r = 0; $r < count($needs_orders[$i]); $r++)
                                    {
                                        $price += $needs_orders[$i][$r]->count * $products[$i][$r]->prace;
                                    }
                                
                                echo '<h2>К оплате: '.$price.' руб.</h2>';
                                ?>

                                @if($check_order[$i] == 0)
                                <a href = "updateorder?name={{$orders_over_name[$i]}}">
                                    <button type="submit" class="btn btn-primary button_rigth">
                                        Редактировать
                                    </button>
                                </a>
                                <form action="{{ route('DeleteO',$orders_over_name[$i]) }}" method="POST">
                                    <input type = hidden name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-primary button_rigth">
                                        Удалить
                                    </button>
                                    {{ csrf_field() }}
                                </form>
                                @elseif($check_order[$i] == 1)
                                    <button type="submit" class="btn btn-primary button_rigth" style = 'background-color: rgb(32, 32, 32);color:white'>
                                        Заказ находится в обработке
                                    </button>
                                @elseif($check_order[$i] == 2)
                                    <form method="POST" action="myorder?name={{$orders_over_name[$i]}}">     
                                        <button type="submit" class="btn btn-primary button_rigth">
                                            Оплатить
                                        </button>
                                        {{ csrf_field() }}
                                    </form>
                                @endif
                            </div>
                        </div><br>
                    @endif
                    @endfor
                @endif
        </div>
    </div>
</div>
@endsection
