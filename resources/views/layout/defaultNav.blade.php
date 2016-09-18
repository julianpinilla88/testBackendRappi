@extends('layout.hd')

@section('nav')
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">ClickDelivery</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="{{route('user.index')}}">Home</a></li>
                    @foreach(Session::get('permission') as $permission)
                        @if($permission->id_permission == 1 AND $permission->id_module == 1)
                            <li><a href="{{route('user.create')}}">Register</a></li>
                        @elseif($permission->id_permission == 3 AND $permission->id_module == 2)
                            <li><a href="{{route('role.index')}}">Roles</a></li>
                        @endif
                    @endforeach
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="javascript:void(0)">{!! Session::get('nameUser') !!}</a></li>
                    <li><a href="{{route('login.show')}}">Log Out</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

@endsection

