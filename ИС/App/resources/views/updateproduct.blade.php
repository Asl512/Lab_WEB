@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $header }}</div>
                    <div class="card-body">
                        <form method="POST" action="updateproduct?id={{$product->id}}">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Название товара</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value = '{{ $product->name }}'>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">Описание</label>
                                <div class="col-md-6">
                                    <input id="description" type="text" class="form-control" name="description" value = '{{ $product->description }}'>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="images" class="col-md-4 col-form-label text-md-right">Изображение</label>
                                <div class="col-md-6">
                                    <select id="images" class="form-control" name="img">
                                    @foreach($images as $image)
                                        @if($image == $product->img)
                                            <option selected value="{{$image}}">{{$image}}</option>
                                        @else
                                            <option value="{{$image}}">{{$image}}</option>
                                        @endif
                                    @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="year_proiz" class="col-md-4 col-form-label text-md-right">Год производства</label>
                                <div class="col-md-6">
                                    <input id="year_proiz" type="number" class="form-control" name="year_proiz" value = '{{ $product->year_proiz }}'>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="price" class="col-md-4 col-form-label text-md-right">Цена</label>
                                <div class="col-md-6">
                                    <input id="price" type="number" class="form-control" name="prace" value = '{{ $product->prace }}'>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="count_prod" class="col-md-4 col-form-label text-md-right">Количество товара</label>
                                <div class="col-md-6">
                                    <input id="count_prod" type="number" class="form-control" name="count" value = '{{ $product->count }}'>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Изменить</button>
                                    {{ csrf_field() }}
                                    <a href = 'index'><button class="btn btn-primary">Отмена</button></a>
                                </div>
                            </div>
                            
                            
                        </form>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                @if($error == 1)
                                    <br><p>Вы не заполнили одно из полей</p>
                                @elseif($error == 2)
                                    <br><p>Цену нельзя поставить меньше 0</p>
                                @elseif($error == 3)
                                    <br><p>Вы указали не коректный год производства</p>
                                @elseif($error == 4)
                                    <br><p>Данное имя уже занято</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
