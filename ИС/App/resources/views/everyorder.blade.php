@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                @if(count($orders_over_name) == 0)
                    <div class="card">
                        <div class="card-header">Новых заказов пока нет</div>
                    </div>
                @else
                    @for($i = 0; $i < count($orders_over_name);$i++)
                    <div class="card">
                        <div class="card-header"><h2>{{ $orders_over_name[$i] }}</h2></div>
                            <div class="card-body">
                                <div class="flex-center position-ref full-height">
                                <h3 class = 'content'>Клиент: {{$shops[$i]->name}}</h3>
                                @for($j = 0; $j < count($needs_orders[$i]); $j++)
                                    <div class = 'contentCard' style='border:1px solid rgba(0, 0, 0, 0.2);; padding: 10px 10px 10px 10px'>
                                        <p class = 'content'><b>{{$products[$i][$j]->name}}</b></p>
                                        <p>Заказано: {{$needs_orders[$i][$j]->count}} шт.</p>
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

                                @if($check_order[$i] == 0)
                                <form method="POST" action="everyorder?name={{$orders_over_name[$i]}}">          
                                    <button type="submit" class="btn btn-primary button_rigth">
                                        Взять заказ
                                    </button>
                                    {{ csrf_field() }}
                                </form>
                                <form action="{{ route('DeleteO',$orders_over_name[$i]) }}" method="POST">
                                    <input type = hidden name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-primary button_rigth">
                                        Отменить заказ
                                    </button>
                                    {{ csrf_field() }}
                                </form>
                                @else
                                    <button type="submit" class="btn btn-primary button_rigth" style = 'background-color: rgb(32, 32, 32);color:white'>
                                        Этот заказ уже взяли
                                    </button>
                                @endif
                            </div>
                        </div><br>
                    @endfor
                @endif
        </div>
    </div>
</div>
@endsection
