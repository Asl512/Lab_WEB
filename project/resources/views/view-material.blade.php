@extends('layouts.site')
@section('title')
<title>{{$material->name_material}}</title>
@endsection
@section('content')
<h1 class="my-md-5 my-4">{{$material->name_material}}</h1>
<div class="row mb-3">
    <div class="col-lg-6 col-md-8">
        <div class="d-flex text-break">
            <p class="col fw-bold mw-25 mw-sm-30 me-2">Авторы</p>
            <p class="col">{{$material->autors}}</p>
        </div>
        <div class="d-flex text-break">
            <p class="col fw-bold mw-25 mw-sm-30 me-2">Тип</p>
            <p class="col">{{$material->type}}</p>
        </div>
        <div class="d-flex text-break">
            <p class="col fw-bold mw-25 mw-sm-30 me-2">Категория</p>
            <p class="col">{{$material->name_category}}</p>
        </div>
        <div class="d-flex text-break">
            <p class="col fw-bold mw-25 mw-sm-30 me-2">Описание</p>
            <p class="col">{{$material->description}}</p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <form method="POST" action="{{route('AddTM', $material->id_material)}}">
            <h3>Теги</h3>
            <div class="input-group mb-3">
                <select name='tag' class="form-select @error('tag') is-invalid @enderror" id="tag" aria-label="Добавьте автора">
                    <option value="0" style='display:none;'>Выберите тег</option>
                    @foreach($tags as $tag)
                    <option value="{{$tag->id_teg}}">{{$tag->name_teg}}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary" type="submit">Добавить</button>
                {{ csrf_field() }}
            </div>
            @error('tag')
            <div class="alert alert-danger">{{$message}}</div>
            @enderror
        </form>
        <ul class="list-group mb-4">
            @if(count($tags_material) == 0)
            <li class="list-group-item list-group-item-action d-flex justify-content-between">
                <h5 class="me-3">У данного материала нет тегов</h5>
            </li>
            @else
            @foreach($tags_material as $tag)
            <li class="list-group-item list-group-item-action d-flex justify-content-between">
                <a href="{{ url('materials?search='.$tag->name_teg) }}" class="me-3">{{$tag->name_teg}}</a>
                <a data-bs-toggle="modal" href="#exampleModalToggle{{$tag->id_teg}}" role="button" class="text-decoration-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                    </svg>
                </a>
            </li>
            @endforeach
            @endif
        </ul>
    </div>
    <div class="col-md-6">
        <div class="d-flex justify-content-between mb-3">
            <h3>Ссылки</h3>
            <a class="btn btn-primary" id='showModalAddLink' role="button" href="#modalAddLink" data-bs-toggle="modal">Добавить</a>
        </div>
        <ul class="list-group mb-4">
            @if(count($links) == 0)
            <li class="list-group-item list-group-item-action d-flex justify-content-between">
                <h5 class="me-3">У данного материала нет ссылок</h5>
            </li>
            @else
            @foreach($links as $link)
            <li class="list-group-item list-group-item-action d-flex justify-content-between">
                <a href="{{ url($link->link) }}" class="me-3">
                    @if($link->name_link == '-')
                    {{$link->link}}
                    @else
                    {{$link->name_link}}
                    @endif
                </a>
                <span class="text-nowrap">
                    <a data-bs-toggle="modal" href="#Updatelink{{$link->id_link}}" role="button" class="text-decoration-none me-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                        </svg>
                    </a>
                    <a data-bs-toggle="modal" href="#linksdelete{{$link->id_link}}" role="button" class="text-decoration-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                        </svg>
                    </a>
                </span>
            </li>
            @endforeach
            @endif
        </ul>
    </div>
</div>
</div>
</div>
@endsection
</div>
@section('end')

@error('link')
<script>
    //скрипт открывающий модальное окно для добавления ссылки
    document.addEventListener('DOMContentLoaded', function() {
        const modal = new bootstrap.Modal(document.querySelector('#modalAddLink'));
        modal.show();
    });
</script>
@enderror

<!-- Модальное окно для добавления ссылки -->

<div class="modal fade" id="modalAddLink" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">Добавить ссылку</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" action="{{route('AddL',$material->id_material)}}">
                <div class="modal-body">

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Напишите название" name='name' id="name">
                        <label for="name">Подпись</label>
                        @error('name')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('link') is-invalid @enderror" value="{{ old('link') }}" placeholder="Напишите ссылку" name='link' id="link">
                        <label for="link">Cсылка</label>
                        @error('link')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Добавить</button>
                    {{ csrf_field() }}
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Отмена</button>
                </div>
            </form>

        </div>
    </div>
</div>

@foreach($links as $link)
<div class="modal fade" id="linksdelete{{$link->id_link}}" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">Подтвердите удаление</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('DeleteLM',$link->id_link,) }}" method="POST">
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

<div class="modal fade" id="Updatelink{{$link->id_link}}" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">Редактировать ссылку</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" action="{{route('SaveL',$link->id_link)}}">
                <div class="modal-body">

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ $link->name_link }}" placeholder="Напишите название" name='name' id="name">
                        <label for="name">Подпись</label>
                        @error('name')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('link') is-invalid @enderror" value="{{ $link->link }}" placeholder="Напишите ссылку" name='link' id="link">
                        <label for="link">Cсылка</label>
                        @error('link')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Сохранить</button>
                    {{ csrf_field() }}
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Отмена</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endforeach

@foreach($tags_material as $tag)
<div class="modal fade" id="exampleModalToggle{{$tag->id_teg}}" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">Подтвердите удаление</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('DeleteTM',$tag->id,) }}" method="POST">
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