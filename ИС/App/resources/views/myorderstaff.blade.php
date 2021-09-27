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
                    <div class="card">
                        <div class="card-header"><h2>{{ $orders_over_name[$i] }}</h2></div>
                            <div class="card-body">
                                <div class="flex-center position-ref full-height">
                                @for($j = 0; $j < count($needs_orders[$i]); $j++)
                                    <div class = 'contentCard' style='border:1px solid rgba(0, 0, 0, 0.2);; padding: 10px 10px 10px 10px'>
                                        <p class = 'content'><b>{{$products[$i][$j]->name}}</b></p>
                                        <p>Заказано: {{$needs_orders[$i][$j]->count}} шт.</p>
                                    </div><br>
                                @endfor
                                </div>

                                <form method="POST" action="myorderstaff?name={{$orders_over_name[$i]}}">          
                                    <button type="submit" class="btn btn-primary button_rigth">
                                        Обработано!
                                    </button>
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </div><br>
                    @endfor
                @endif
        </div>
    </div>
</div>
@endsection
