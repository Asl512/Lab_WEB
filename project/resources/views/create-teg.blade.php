@extends('layouts.site')
@section('title')
<title>Добавить тег</title>
@endsection
@section('content')
<h1 class="my-md-5 my-4">Добавить тег</h1>
<div class="row">
    <div class="col-lg-5 col-md-8">
        <form method="POST" action="{{route('CreateT')}}">
            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Напишите название" name='name' id="name">
                <label for="name">Название</label>

                @error('name')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror

            </div>
            <button class="btn btn-primary" type="submit">Добавить</button>
            {{ csrf_field() }}
        </form>
    </div>
</div>
@endsection