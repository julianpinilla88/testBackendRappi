@extends('layout.defaultNav')

@section('content')
    @include('message.error')
    {!! Form::open(['route'=>'password.update', 'method'=>'PUT']) !!}
    <div class="form-group">
        {!! Form::label('Password:') !!}
        {!! Form::password('txtPassword',['class' => 'form-control']) !!}
        {!! Form::hidden('hdUser', $idUser) !!}
    </div>
    {!! Form::submit('Save',['class'=>'btn btn-primary']) !!}
    {!! Form::close() !!}

@endsection