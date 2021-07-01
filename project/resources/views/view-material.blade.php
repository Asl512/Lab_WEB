@extends('layouts.site')
@section('content')
            <h1 class="my-md-5 my-4">{{$header}}</h1>
            <div class="row mb-3">
                <div class="col-lg-6 col-md-8">
                    <div class="d-flex text-break">
                        <p class="col fw-bold mw-25 mw-sm-30 me-2">Авторы</p>
                        <p class="col">{{$material->autors}}</p>
                    </div>
                    <div class="d-flex text-break">
                        <p class="col fw-bold mw-25 mw-sm-30 me-2">Тип</p>
                        <p class="col">{{$material->fk_id_type}}</p>
                    </div>
                    <div class="d-flex text-break">
                        <p class="col fw-bold mw-25 mw-sm-30 me-2">Категория</p>
                        <p class="col">{{$material->fk_id_category}}</p>
                    </div>
                    <div class="d-flex text-break">
                        <p class="col fw-bold mw-25 mw-sm-30 me-2">Описание</p>
                        <p class="col">{{$material->description}}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <form method="POST" action="{{route('AddTM', $material->id)}}">
                        <h3>Теги</h3>
                        <div class="input-group mb-3">
                            <select name ='teg' class="form-select" id="selectAddTag" aria-label="Добавьте автора">
                                @foreach($tags as $tag)
                                    <option value="{{$tag->id}}">{{$tag->name}}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-primary" type="submit">Добавить</button>
                            {{ csrf_field() }}
                        </div>
                        @if($error == 1)
                            <div>Данный тег уже существует</div>
                        @endif
                    </form>
                    <ul class="list-group mb-4">
                        @if(count($tags_material) == 0)
                            <li class="list-group-item list-group-item-action d-flex justify-content-between">
                                <h5 class="me-3">У данного материала нет тегов</h5>
                            </li>
                        @else
                            @foreach($tags_material as $tag)
                                <li class="list-group-item list-group-item-action d-flex justify-content-between">
                                    <a href="{{ url('materials?search='.$tag->name) }}" class="me-3">{{$tag->name}}</a>
                                    <a data-bs-toggle="modal" href="#exampleModalToggle{{$tag->id}}" role="button" class="text-decoration-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                            <path fill-rule="evenodd"
                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
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
                        <a class="btn btn-primary" data-bs-toggle="modal" href="#exampleModalToggle" role="button">Добавить</a>
                    </div>
                    <ul class="list-group mb-4">
                        @if(count($links) == 0)
                            <li class="list-group-item list-group-item-action d-flex justify-content-between">
                                <h5 class="me-3">У данного материала нет ссылок</h5>
                            </li>
                        @else
                            @foreach($links as $link)
                                <li class="list-group-item list-group-item-action d-flex justify-content-between">
                                    <a href="{{ url($link->link) }}" class="me-3">{{$link->name}}</a>
                                    <span class="text-nowrap">
                                        <a data-bs-toggle="modal" href="#linksdelete{{$link->id}}" role="button" class="text-decoration-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
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
    @foreach($links as $link)
        <div class="modal fade" id="linksdelete{{$link->id}}" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalToggleLabel">Подтвердите удаление</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('DeleteLM',$link->id,) }}" method="POST">
                        <div class="modal-body">
                            <input type = hidden name="_method" value="DELETE">
                            <button type="submit" class="btn btn-primary">Удалить</button>
                            {{ csrf_field() }}
                            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Отмена</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @foreach($tags_material as $tag)
        <div class="modal fade" id="exampleModalToggle{{$tag->id}}" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalToggleLabel">Подтвердите удаление</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('DeleteTM',$tag->id,) }}" method="POST">
                        <div class="modal-body">
                            <input type = hidden name="_method" value="DELETE">
                            <button type="submit" class="btn btn-primary">Удалить</button>
                            {{ csrf_field() }}
                            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Отмена</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
     tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" action="{{ route('SaveL',$material->id,) }}" method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">Добавить ссылку</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name='name' placeholder="Добавьте подпись"
                           id="floatingModalSignature">
                    <label for="floatingModalSignature">Подпись</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name='link' placeholder="Добавьте ссылку" id="floatingModalLink">
                    <label for="floatingModalLink">Ссылка</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Добавить</button>
                {{ csrf_field() }}
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Закрыть</button>
            </div>
        </form>
    </div>
</div>
@endsection