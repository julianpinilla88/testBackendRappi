@extends('layout.hd')

@section('nav')
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{route('index')}}">Rappi</a>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

@endsection

