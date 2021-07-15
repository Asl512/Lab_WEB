@extends('layouts.site')
@section('title')
<title>Редактировать категорию</title>
@endsection
@section('content')
<h1 class="my-md-5 my-4">Редактировать категорию</h1>
<div class="row">
    <div class="col-lg-5 col-md-8">
        <form method="POST" action="{{route('SaveC',$category->id_category)}}">
            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{$category->name_category}}" placeholder="Напишите название" name='name' id="name">
                <label for="name">Название</label>

                @error('name')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror

            </div>
            <button class="btn btn-primary" type="submit">Сохранить</button>
            {{ csrf_field() }}
        </form>
    </div>
</div>
@endsection