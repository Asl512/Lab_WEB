@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Добавить сотрудника</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('AddSt') }}">

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Имя сотрудника</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $name }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Почта</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $email }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Пароль') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Добавить</button>
                                    {{ csrf_field() }}
                                </div>
                            </div><br>
                            </form>
                            </div>
                        </div><br>
                        
                        <div class="card">
                        <div class="card-header">{{ $header }}</div>
                        <div class="card-body">
                        @if(count($users) == 0)
                        <h2>Сотрудников пока нет</h2>
                        @else
                        <table style = "border-collapse: collapse; margin:auto">
                            <tr>
                                <th style = 'border:1px solid rgba(0, 0, 0, 0.2); padding: 10px 10px 10px 10px; '>Имя сотрудника</th>
                                <th style = 'border:1px solid rgba(0, 0, 0, 0.2); padding: 10px 10px 10px 10px; '>Почта сотрудника</th>
                                <th style = 'border:1px solid rgba(0, 0, 0, 0.2); padding: 10px 10px 10px 10px; '>Удалить</th>
                            </tr>
                            @foreach($users as $user)
                                <tr>
                                    <td style = 'border:1px solid rgba(0, 0, 0, 0.2); padding: 10px 10px 10px 10px; '>{{$user->name}}</td>
                                    <td style = 'border:1px solid rgba(0, 0, 0, 0.2); padding: 10px 10px 10px 10px; '>{{$user->email}}</td>
                                    <td style = 'border:1px solid rgba(0, 0, 0, 0.2); padding: 10px 10px 10px 10px; '>
                                        <form action="{{ route('DeleteSt',$user->id) }}" method="POST">
                                            <input type = hidden name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-primary button_rigth">
                                                Удалить
                                            </button>
                                            {{ csrf_field() }}
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        @endif
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                @if($error == 1)
                                    <br><p>Вы не ввели одно из полей</p>
                                @elseif($error == 2)
                                    <br><p>Данные email адрес уже зарегистрован</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
