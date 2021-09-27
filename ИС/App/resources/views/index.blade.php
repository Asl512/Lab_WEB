@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach($products as $product)
            <div class="card">
                <div class="card-header"><b>{{ $product->name }}</b>
                    @if($error == 1)
                        <p><em>Данный товар нельзя удалить, так как на него существуют заявки</em></p>
                    @endif
                </div>

                <div class="card-body">
                    <div class="flex-center position-ref full-height">
                        <div class = 'dis'>
                            <img src="images/{{ $product->img }}" class = 'images'>
                            <div class = 'contentCard'>
                                <p class = 'content'>{{$product->description}}</p>
                                <p>Год производства: {{ $product->year_proiz }}</p>
                                <p>В наличии: {{$product->count}} шт.</p>
                                <h2>Цена: {{ $product->prace }}</h2>
                            </div>
                        </div>
                        @guest
                        @else
                            @if(Auth::user()->status == 1)
                                <a href = 'updateproduct?id={{$product->id}}'>
                                    <button type="submit" class="btn btn-primary button_rigth">
                                        Редактировать
                                    </button>
                                </a>
                            <form action="{{ route('DeleteP',$product->id) }}" method="POST">
                                    <input type = hidden name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-primary button_rigth">
                                        Удалить
                                    </button>
                                    {{ csrf_field() }}
                                </form>
                            @elseif(Auth::user()->status == 0)
                                <form method="POST" action="{{ route('Bas', $product->id) }}">
                                    <button type="submit" class="btn btn-primary button_rigth">
                                        Добавить в корзину
                                    </button>
                                    {{ csrf_field() }}
                                </form>
                            @elseif(Auth::user()->status == 2)
                                <a href="{{ url('suppli') }}">
                                    <button type="submit" class="btn btn-primary button_rigth">
                                        Поставить
                                    </button>
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            </div><br>
            @endforeach
        </div>
    </div>
</div>
@endsection
