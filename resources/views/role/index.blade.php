@extends('layout.defaultNav')

@section('content')
    @include('message.message')
    <table class="table">
        <thead>
            <tr>
                <td>Name</td>
                <td>Role</td>
                <td width="5"></td>
            </tr>
        </thead>
        <tbody>
        @foreach($arrUserXRole as $user)
            <tr>
                <td>{{$user->name_user}}</td>
                <td>{{$user->nom_role}}</td>
                <td>{!! ((!empty(Session::get('mod'))) ? link_to_route('role.edit', $title = '', $parameters = $user->id_role_xuser, $attributes = ['class'=>'glyphicon glyphicon-pencil']) : '')  !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection