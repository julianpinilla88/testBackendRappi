@extends('layout.defaultNav')

@section('content')
    @include('message.error')
    {!! Form::open(['route'=>'user.'.$nomEvent, 'method'=>(($idEvent == 1) ? 'POST' : 'PUT')]) !!}
    <div class="form-group">
        {!! Form::label('Name:') !!}
        {!! Form::text('txtName',((isset($objUser)) ? $objUser['name_user'] : null),['class' => 'form-control', 'placeholder'=>'Name User']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Phone Number:') !!}
        {!! Form::text('txtPhoneNumber',((isset($objUser)) ? $objUser['phone_number'] : null),['class'=>'form-control', 'placeholder'=>'3003253654']) !!}
    </div>
    @if($idEvent == 1)
        <div class="form-group">
            {!! Form::label('Email:') !!}
            {!! Form::email('txtEmail',((isset($objUser)) ? $objUser['email'] : null),['class'=>'form-control', 'placeholder'=>'example@gmail.com']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('Password:') !!}
            {!! Form::password('txtPassword',['class' => 'form-control']) !!}
        </div>
        {!! Form::submit('Save',['class'=>'btn btn-primary']) !!}
    @elseif($idEvent == 2)
        @if(!empty($idRoleStatusMod))
            {!! Form::select('optEst', Session::get('estUser'), null, ['class'=>'form-control']) !!}
            @endif
        {!! Form::hidden('hdUser', $objUser['id_user']) !!}
        {!! Form::submit('Update',['class'=>'btn btn-info']) !!}
    @endif
    {!! Form::close() !!}

@endsection