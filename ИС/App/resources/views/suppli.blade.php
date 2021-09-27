@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $header }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('AddS') }}">

                        <div class="form-group row">
                                    <label for="name_suppli_value" class="col-md-4 col-form-label text-md-right">Название накладной</label>
                                    <div class="col-md-6">
                                        <input id="name_suppli_value" type="text" class="form-control" name="name_suppli_value" value ='{{$name_suppli_value}}'>
                                    </div>
                                </div>

                        @foreach($products as $product)
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right"></label>
                                    <div class="col-md-6">
                                        <input id="name" type="text" readonly class="form-control" name="name_{{$product->id}}" value ='{{$product->name}}'>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="count_prod" class="col-md-4 col-form-label text-md-right">Количество</label>
                                    <div class="col-md-6">
                                        <input id="count_prod" type="number" class="form-control" name="count_{{$product->id}}" value = '0'>
                                    </div>
                                </div>
                            @endforeach

                                

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Отправить</button>
                                    {{ csrf_field() }}
                                    <a href = 'index'><button class="btn btn-primary">Отмена</button></a>
                                </div>
                            </div>
                            
                        </form>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                @if($error == 1)
                                    <br><p>Вы не внесли ни один товар</p>
                                @elseif($error == 4)
                                    <br><p>Вы не ввели имя накладной</p>
                                @elseif($error == 5)
                                    <br><p>Данное имя накладной уже занято</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
