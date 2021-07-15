@extends('layouts.site')
@section('title')
<title>Материалы</title>
@endsection

@section('content')
<h1 class="my-md-5 my-4">Материалы</h1>
<a class="btn btn-primary mb-4" href="{{ url('create-material') }}" role="button">Добавить</a>
<div class="row">
    <div class="col-md-8">
        <form action="{{ route('Materials')}}" method="GET">
            <div class="input-group mb-3">
                <input type="text" name='search' class="form-control" value="{{$search}}" placeholder="Поиск" aria-label="Example text with button addon" aria-describedby="button-addon1">
                <button class="btn btn-primary" type="submit" id="button-addon1">Искать</button>
                {{ csrf_field() }}
            </div>
        </form>
    </div>
</div>
<div class="table-responsive">
    <table class="table">
        @if(count($materials) == 0)
        <thead>
            <tr>
                @if($search == '')
                <th scope="col">Материалов в базе пока что нет <a href="{{ url('create-material') }}">добавить?</a></th>
                @else
                <th scope="col">Материалов по поиску "{{$search}}" не найдено, <a href="{{ url('create-material') }}">добавить?</a></th>
                @endif
            </tr>
        </thead>
        @else
        <thead>
            <tr>
                <th scope="col">Название</th>
                <th scope="col">Автор</th>
                <th scope="col">Тип</th>
                <th scope="col">Категория</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($materials as $material)
            <tr>
                <td><a href="{{ url('view-material?id='.$material->id_material) }}">{{$material->name_material}}</a></td>
                <td>{{$material->autors}}</td>
                <td>{{$material->type}}</td>
                <td>{{$material->name_category}}</td>
                <td class="text-nowrap text-end">
                    <a href="update-material?id={{$material->id_material}}" class="text-decoration-none me-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                        </svg>
                    </a>
                    <a data-bs-toggle="modal" href="#exampleModalToggle{{$material->id_material}}" role="button" class="text-decoration-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                        </svg>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
        @endif
    </table>
</div>
@endsection
@section('end')
@foreach($materials as $material)
<div class="modal fade" id="exampleModalToggle{{$material->id_material}}" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">Подтвердите удаление</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('DeleteM',$material->id_material) }}" method="POST">
                <div class="modal-body">
                    <input type=hidden name="_method" value="DELETE">
                    <button type="submit" class="btn btn-primary">Удалить</button>
                    {{ csrf_field() }}
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Отмена</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection