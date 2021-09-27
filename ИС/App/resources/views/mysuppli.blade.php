@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                @if(count($suppli_over_name) == 0)
                    <div class="card">
                        <div class="card-header">У вас пока нет накладных</div>
                    </div>
                @else
                    @for($i = 0; $i < count($suppli_over_name);$i++)
                    <div class="card">
                        <div class="card-header"><h2>{{ $suppli_over_name[$i] }}</h2></div>
                            <div class="card-body">
                                <div class="flex-center position-ref full-height">
                                @for($j = 0; $j < count($needs_suppli[$i]); $j++)
                                    <div class = 'contentCard' style='border:1px solid rgba(0, 0, 0, 0.2);; padding: 10px 10px 10px 10px'>
                                        <p class = 'content'><b>{{$products[$i][$j]->name}}</b></p>
                                        <p>Вы поставили: {{$needs_suppli[$i][$j]->count}} шт.</p>
                                    </div><br>
                                @endfor
                                </div>
                            </div>
                        </div><br>
                    @endfor
                @endif
        </div>
    </div>
</div>
@endsection
