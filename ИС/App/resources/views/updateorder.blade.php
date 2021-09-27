@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $header }}</div>

                    <div class="card-body">
                        <form method="POST" action="updateorder?name={{$name_order_value}}">

                        <div class="form-group row">
                                    <label for="name_order" class="col-md-4 col-form-label text-md-right">Номер заявки</label>
                                    <div class="col-md-6">
                                        <input id="name_order" type="text" class="form-control" readonly name="name_order" value ='{{$name_order_value}}'>
                                    </div>
                                </div>

                            @for($i=0;$i < count($orders); $i++)
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right"></label>
                                    <div class="col-md-6">
                                        <input id="name" type="text" readonly class="form-control" value ='{{$products[$i]->name}}'>
                                    </div>
                                    <!-- <form action="{{ route('DeleteB',$products[$i]->id) }}" method="POST">
                                        <input type = hidden name="_method" value="DELETE"> -->
                                        <button type="submit" class="btn btn-primary button_rigth" style='background:rgb(255, 59, 59); border: 1px solid rgb(255, 59, 59);'>
                                            X
                                        </button>
                                       <!-- {{ csrf_field() }}
                                    </form> -->
                                </div>

                                <div class="form-group row">
                                    <label for="count_prod" class="col-md-4 col-form-label text-md-right">Количество</label>
                                    <div class="col-md-6">
                                        <input id="count_prod" type="number" class="form-control" name="count_{{$orders[$i]->id}}" value = '{{$orders[$i]->count}}'>
                                    </div>
                                </div>
                            @endfor

                                

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Изменить</button>
                                    {{ csrf_field() }}
                                </div>
                            </div>
                            
                        </form>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                @if($error == 1)
                                    <br><p>Товар не может быть ниже 0</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
