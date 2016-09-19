@extends('layout.defaultNav')

@section('content')
    @include('message.message')
    @include('message.error')
    {!! Form::open(['route'=>'matriz.update', 'method'=>'PUT']) !!}
    <a href="{{route('index')}}">Volver a iniciar la prueba</a>
    <div class="form-group">
        <div>
            {!! Form::label('Ingrese la operaci&oacute;n: :') !!}
            <div class="input-group">
                {!! Form::text('txtOpeCaso',null,['class' => 'form-control', 'placeholder'=>'Ingrese la oepraci&oacute;n con los parametros UPDATE o QUERY']) !!}
                <span class="input-group-btn">
                        {!! Form::submit('Ejecutar',['class'=>'btn btn-success']) !!}
                </span>
            </div>
        </div>
    </div>

    {!! Form::close() !!}

    <div class="container">
        <table class="table">
            @foreach($arrResp as $resp)
                <tr>
                    <td>{{$resp['operacion']}}</td>
                    <td>{{$resp['resp']}}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection