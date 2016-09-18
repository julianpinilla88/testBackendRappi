@extends('layout.defaultNav')

@section('content')
    @include('message.error')
    {!! Form::open(['route'=>'role.update', 'method'=>'PUT']) !!}
    <div class="form-group">
        {!! Form::label('Role:') !!}
        {!! Form::select('optRole', $objRole, null, ['class'=>'form-control']) !!}
    </div>
    {!! Form::hidden('hdUserRole', $id) !!}
    {!! Form::submit('Update',['class'=>'btn btn-info']) !!}
    {!! Form::close() !!}

@endsection