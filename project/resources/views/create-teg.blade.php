@extends('layouts.site')
@section('content')
    <h1 class="my-md-5 my-4">{{$header}}</h1>
    <div class="row">
        <div class="col-lg-5 col-md-8">
             @if($status == 1)
                <form method="POST" action="{{route('SaveT')}}">
            @else
                <form method="POST" action="{{route('UpdateT', $id)}}">
            @endif
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name = 'name' placeholder="Напишите название" id="floatingName" value="{{$value}}">
                    <label for="floatingName">Название</label>

                    @if($error == 1)
                        <div> Пожалуйста, заполните поле</div>
                    @elseif($error == 2)
                        <div> Данный тег уже существует</div>
                    @endif

                </div>
                <button class="btn btn-primary" type="submit">
                    @if($status == 1)
                        Добавить
                    @else
                        Изменить
                    @endif
                </button>
                {{ csrf_field() }}
            </form>
        </div>
    </div>
@endsection
