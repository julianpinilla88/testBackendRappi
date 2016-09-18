@extends('layout.defaultNav')

@section('content')
    @include('message.message')
    <table class="table">
        <thead>
            <tr>
                <td>Name</td>
                <td>Email</td>
                <td>Phone</td>
                <td>Status</td>
                <td width="5"></td>
            </tr>
        </thead>
        <tbody>
        @foreach($arrUser as $user)
            <tr>
                <td>{{$user->name_user}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->phone_number}}</td>
                <td>{{$user->nom_est_user}}</td>
                <td>{!! (($user->idMod == 1) ? link_to_route('user.edit', $title = '', $parameters = $user->id_user, $attributes = ['class'=>'glyphicon glyphicon-pencil']) : '')  !!}</td>
                <td>{!! (($user->pass == 1) ? link_to_route('password.edit', $title = '', $parameters = $user->id_user, $attributes = ['class'=>'glyphicon glyphicon-user']) : '')  !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection