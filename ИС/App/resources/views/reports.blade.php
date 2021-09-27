@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="card">
                    <div class="card-header">Отчеты по продажам</div>

                    <div class="card-body">

                    <form method="POST" action="{{ route('PostS') }}">

                        <div class="form-group row">
                            <label for="name_order" class="col-md-4 col-form-label text-md-right">От</label>
                            <div class="col-md-6">
                                <input type = 'date' class="form-control" name = 'from'>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name_order" class="col-md-4 col-form-label text-md-right">До</label>
                            <div class="col-md-6">
                                <input type = 'date' class="form-control" name = 'befor'>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">Показать</button>
                                {{ csrf_field() }}
                            </div>
                        </div>

                    </form>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                @if($error == 1)
                                    <p>Первый месяц должен быть меньше второго</p>
                                @endif
                            </div>
                        </div>
                                
                    </div>
                </div><br>

                <div class="card">
                    <div class="card-header">Отчет по продажам сотрудников</div>
                    <div class="card-body">
                        <table style = "border-collapse: collapse; margin:auto">
                            <tr>
                                <th style = 'border:1px solid rgba(0, 0, 0, 0.2); padding: 10px 10px 10px 10px; '>Имя сотрудника</th>
                                <th style = 'border:1px solid rgba(0, 0, 0, 0.2); padding: 10px 10px 10px 10px; '>Количество продаж</th>
                            </tr>
                            @for($i = 0; $i < count($users); $i++)
                                <tr>
                                    <td style = 'border:1px solid rgba(0, 0, 0, 0.2); padding: 10px 10px 10px 10px; '>{{$users[$i]->name}}</td>
                                    <td style = 'border:1px solid rgba(0, 0, 0, 0.2); padding: 10px 10px 10px 10px; '>{{$numb_ord[$i]}}</td>
                                </tr>
                            @endfor
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
