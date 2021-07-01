@extends('layouts.site')
@section('content')
    <h1 class="my-md-5 my-4">{{$header}}</h1>
    <div class="row">
        <div class="col-lg-5 col-md-8">
            @if($status == 1)
                <form method="POST" action="{{route('SaveM')}}">
            @else
                <form method="POST" action="{{route('UpdateM', $id)}}">
            @endif
                <div class="form-floating mb-3">
                    <select class="form-select" id="floatingSelectType" name = 'type'>
                        <option value ='-10' selected style='display:none;'>Выберите тип</option>
                        @foreach($types as $type)
                            @if($type_id == $type->id)
                                <option selected value = "{{$type->id}}">{{$type->name}}</option>
                            @else
                                <option value = "{{$type->id}}">{{$type->name}}</option>
                            @endif
                        @endforeach
                    </select>
                    <label for="floatingSelectType">Тип</label>
                    @if($error == 1)
                        @if($type_id == -10)
                            <div>Пожалуйста, выберите тип</div>
                        @endif
                    @endif
                </div>

                <div class="form-floating mb-3">
                    <select class="form-select" id="floatingSelectCategory" name = 'category'>
                        <option value ='-10' selected style='display:none;'>Выберите категорию</option>
                        @foreach($categoryes as $category)
                            @if($category_id == $category->id)
                                <option selected value="{{$category->id}}">{{$category->name}}</option>
                            @else
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endif
                        @endforeach    
                    </select>
                    <label for="floatingSelectCategory">Категория</label>
                    @if($error == 1)
                        @if($category_id == -10)
                            <div>Пожалуйста, выберите категорию</div>
                        @endif
                    @endif
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" placeholder="Напишите название" name = 'name' value = '{{$name}}' id="floatingName">
                    <label for="floatingName">Название</label>

                    @if($error == 1)
                        @if($name == '')
                            <div>Пожалуйста, заполните поле</div>
                        @endif
                    @endif

                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" placeholder="Напишите авторов" id="floatingAuthor" value = '{{$autors}}' name='autors'>
                    <label for="floatingAuthor">Авторы</label>
                </div>

                <div class="form-floating mb-3">
                    <textarea name='description' class="form-control" placeholder="Напишите краткое описание" id="floatingDescription"style="height: 100px">{{$description}}</textarea>
                    <label for="floatingDescription">Описание</label>

                    @if($error == 2)
                        <div>Одно из полей было пустым</div>
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