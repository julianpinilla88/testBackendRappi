@extends('layout.defaultNav')

@section('content')
    @include('message.message')
    @include('message.error')
    {!! Form::open(['route'=>'matriz.store', 'method'=>'POST']) !!}
    <div class="form-group">
        <div>
            {!! Form::label('Numero de Casos:') !!}
            {!! Form::text('txtNumCaso',null,['class' => 'form-control', 'placeholder'=>'Ingrese el N&uacute;mero de Casos de Prueba']) !!}
            {!! Form::label('Matriz y Ejecuci&oacute;n:') !!}
            {!! Form::text('txtMatriz',null,['class' => 'form-control', 'placeholder'=>'Ingrese el N&uacute;mero que define la matriz y la cantidad de operaciones a realizar. Deben estar separados por un espacio']) !!}
            <br>
            {!! Form::submit('Iniciar',['class'=>'btn btn-primary']) !!}
        </div>
    </div>

    {!! Form::close() !!}
@endsection