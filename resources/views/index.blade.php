@extends('layout.hd')
{!! Html::style('../public/css/style.css') !!}
{!! Html::style('../public/css/bootstrap-social.css') !!}
{!! Html::style('../public/css/font-awesome.css') !!}

<div class="wrapper">
    {!! Form::open(['route'=>'login.store', 'method'=>'POST', 'class'=>'form-signin']) !!}
    @include('message.message')
    @include('message.error')
    <h2 class="form-signin-heading">Please login</h2>
    {!! Form::email('txtEmail',null,['class' => 'form-control', 'placeholder'=>'example@gmail.com']) !!}
    {!! Form::password('txtPassword',['class'=>'form-control', 'placeholder'=>'password']) !!}
    {!!Form::submit('Login',['class'=>'btn btn-lg btn-primary btn-block'])!!}
    <a href="{{route('facebook.login')}}" class="btn btn-block btn-social btn-facebook">
        <span class="fa fa-facebook"></span> Sign in with Facebook
    </a>
    {!! Form::close() !!}
</div>