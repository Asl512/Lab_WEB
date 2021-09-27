@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

                @if(count($orders_over_name) == 0)
                    <div class="card">
                        <div class="card-header">По данным срокам продаж не было</div>
                    </div>
                @else
                    @for($i = 0; $i < count($needs_orders);$i++)
                    <div class="card">
                        <div class="card-header"><h2>{{ $orders_over_name[$i] }}</h2></div>
                            <div class="card-body">
                                <div class="flex-center position-ref full-height">
                                    <div class = 'contentCard' style='border:1px solid rgba(0, 0, 0, 0.2);; padding: 10px 10px 10px 10px'>
                                    @for($j = 0; $j < count($needs_orders[$i]); $j++)
                                            <p class = 'content'><b>{{$products[$i][$j]->name}}:</b> {{$needs_orders[$i][$j]->count}} шт.</p>
                                    @endfor
                                    </div><br>
                                    <div class = 'contentCard' style='border:1px solid rgba(0, 0, 0, 0.2);; padding: 10px 10px 10px 10px'>
                                        <p class = 'content'>Дата регистрации заказа: {{$created[$i]}}</p>
                                        <p class = 'content'>Дата готовности заказа: {{$readed[$i]}}</p>
                                    </div><br>
                                </div>

                                <?php
                                $price = 0;
                                    for($r = 0; $r < count($needs_orders[$i]); $r++)
                                    {
                                        $price += $needs_orders[$i][$r]->count * $products[$i][$r]->prace;
                                    }
                                
                                echo '<h4>Выручка: '.$price.' руб.</h4>';
                                ?>

                            </div>
                        </div><br>
                    @endfor

                    <div class="card">
                        <div class="card-header" style = 'background:#3490dc;color:white;'><h2>Итог</h2></div>
                            <div class="card-body">

                                <?php
                                $price = 0;
                                for($i = 0; $i < count($needs_orders);$i++)
                                {
                                    for($r = 0; $r < count($needs_orders[$i]); $r++)
                                    {
                                        $price += $needs_orders[$i][$r]->count * $products[$i][$r]->prace;
                                    }
                                }
                                echo '<h2>Итого выручка: '.$price.' руб.</h2>';
                                ?>

                            </div>
                        </div><br>

                @endif
                
            </div>
        </div>
    </div>
</div>
@endsection
