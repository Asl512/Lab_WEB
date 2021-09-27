@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $header }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('AddP') }}">

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Название товара</label>
                                <div class="col-md-6">
                                    <input id="count_prod" type="text" class="form-control" name="name" value = '{{ $name_value }}' placeholder="Ноутбук Lenovo Legion 5">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="img" class="col-md-4 col-form-label text-md-right">Изображение</label>
                                <div class="col-md-6">
                                    <select id="img" type="text" class="form-control" name="img">
                                        @foreach($images as $img)
                                            @if($img_value == $img)
                                                <option value = '{{ $img }}' selected>{{ $img }}</option>
                                            @else
                                                <option value = '{{ $img }}'>{{ $img }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description_inp" class="col-md-4 col-form-label text-md-right">Описание</label>
                                <div class="col-md-6">
                                    <input id="description_inp" type="text" class="form-control" name="description" value = '{{ $description_value }}' placeholder = 'Настоящий игровой зверь на базе процессоров AMD '>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="price" class="col-md-4 col-form-label text-md-right">Цена</label>
                                <div class="col-md-6">
                                    <input id="price" type="number" class="form-control" name="prace" value = '{{ $price_value }}'>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="year" class="col-md-4 col-form-label text-md-right">Дата производства</label>
                                <div class="col-md-6">
                                    <input id="year" type="date" class="form-control" name="year_proiz" value="{{$date_value}}">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Добавить товар</button>
                                    {{ csrf_field() }}
                                </div>
                            </div>
                            
                        </form>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                @if($error == 1)
                                    <br><p>Имя товара уже существует</p>
                                @elseif($error == 2)
                                    <br><p>Дата не может быть прошедшей</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
