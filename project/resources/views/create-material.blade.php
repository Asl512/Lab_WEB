@extends('layouts.site')
@section('title')
<title>Добавление материала</title>
@endsection

@section('content')
<h1 class="my-md-5 my-4">Добавление материала</h1>
<div class="row">
    <div class="col-lg-5 col-md-8">
        <form method="POST" action="{{route('AddM')}}">
            <div class="form-floating mb-3">
                <select class="form-select @error('type') is-invalid @enderror" id="type" name='type'>
                    <option value='0' style='display:none;'>Выберите тип</option>
                    @foreach($types as $type)
                    @if($type == old('type'))
                    <option selected value="{{$type}}">{{$type}}</option>
                    @else
                    <option value="{{$type}}">{{$type}}</option>
                    @endif
                    @endforeach
                </select>
                <label for="type">Тип</label>

                @error('type')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <select class="form-select @error('category') is-invalid @enderror" id="category" name='category'>
                    <option value='0' style='display:none;'>Выберите категорию</option>
                    @foreach($categoryes as $category)
                    @if($category->id_category == old('category'))
                    <option selected value="{{$category->id_category}}">{{$category->name_category}}</option>
                    @else
                    <option value="{{$category->id_category}}">{{$category->name_category}}</option>
                    @endif
                    @endforeach
                </select>
                <label for="category">Категория</label>

                @error('category')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Напишите название" name='name' id="name">
                <label for="name">Название</label>

                @error('name')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror

            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" value="{{ old('autors') }}" placeholder="Напишите авторов" id="autors" name='autors'>
                <label for="autors">Авторы</label>
            </div>

            <div class="form-floating mb-3">
                <textarea name='description' class="form-control" placeholder="Напишите краткое описание" id="description" style="height: 100px">{{ old('description') }}</textarea>
                <label for="description">Описание</label>

            </div>

            <button class="btn btn-primary" type="submit">Добавить</button>
            {{ csrf_field() }}
        </form>
    </div>
</div>
@endsection