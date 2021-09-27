@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <div class="card">
                @if(count($products) > 0)
                    <div class="card-header">{{ $header }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('AddO') }}">
                                <div class="form-group row">
                                    <label for="name_order" class="col-md-4 col-form-label text-md-right">Номер вашей заявки</label>
                                    <div class="col-md-6">
                                        <input id="name_order" type="text" class="form-control" name="name_order" readonly value ='{{$name_order_value}}'>
                                    </div>
                                </div>
 
                            @foreach($products as $product)
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right"></label>
                                    <div class="col-md-6">
                                        <input id="name" type="text" readonly class="form-control" name="name_{{$product->id}}" value ='{{ $product->name }}'>
                                    </div>
                                    <!-- <form action="{{ route('DeleteB',$product->id) }}" method="POST">
                                        <input type = hidden name="_method" value="DELETE"> -->
                                        <button type="submit" class="btn btn-primary button_rigth" style='background:rgb(255, 59, 59); border: 1px solid rgb(255, 59, 59);'>
                                            X
                                        </button>
                                       <!-- {{ csrf_field() }}
                                    </form> -->
                                </div>

                                <div class="form-group row">
                                    <label for="count_prod" class="col-md-4 col-form-label text-md-right">Количество</label>
                                    <div class="col-md-6">
                                        <input id="count_prod" type="number" class="form-control" name="count_{{$product->id}}" value = '1' min='1'>
                                    </div>
                                </div>
                            @endforeach

                                

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Заказать</button>
                                    {{ csrf_field() }}
                                </div>
                            </div>
                        </form>
                        @else
                            <div class="card-header">Корзина пока пустая</div>
                        @endif
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                @if($error == 1)
                                    @foreach($products as $product)
                                            @if($product->name == $name_in_error)
                                                <br><p>Товара <b>{{$name_in_error}}</b> осталось всего: {{ $product->count }}</p>
                                            @endif
                                    @endforeach
                                @elseif($error == 3)
                                    <br><p>Товар <b>{{$name_in_error}}</b> закончился</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
