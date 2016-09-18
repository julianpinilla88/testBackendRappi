<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Service\Service;
use App\Http\Requests;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserEditRequest;
use App\Http\Controllers\Controller;
use App\User;
use App\EstUser;
use Illuminate\Support\Facades\Auth;
use Session;
use Redirect;
use Socialite;


class UserController extends Controller
{
    const MSJ_REG_SUCCESS = 'The user was created succesfully';
    const MSJ_UPD_SUCCESS = 'The user was updated succesfully';
    const MSJ_PERMISSION = 'You don\'t have permissions for execute this action';
    const ID_MODULE = 1;

    public function __construct(Redirect $redirect)
    {
        if (Auth::guest()) {
            $redirect::to('/')->send();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $objService = new Service();
        $idRole = $objService->getPermission(self::ID_MODULE, 3, Session::get('id_role'));
        $idMod = $objService->getPermission(self::ID_MODULE, 5, Session::get('id_role'));
        if (!empty($idRole)) {
            $user = User::all();
            $arrUser = [];
            foreach ($user as $users) {
                $objEstUser = EstUser::where('id_est_user', $users->id_est_user)->first();
                $users->nom_est_user = $objEstUser->nom_est_user;
                $users->idMod = ((!empty($idMod)) ? ((Auth::user()->id_user == $users->id_user) ? 1 : 0) : ((!empty($idRole)) ? 1 : 0));
                $users->pass = ((Auth::user()->id_user == $users->id_user) ? 1 : 0);
                $arrUser[] = $users;
            }
        } else {
            $user = User::where('id_user', Auth::user()->id_user)->first();
            $objEstUser = EstUser::where('id_est_user', Auth::user()->id_est_user)->first();
            $user->nom_est_user = $objEstUser->nom_est_user;
            $user->idMod = 1;
            $arrUser[] = $user;
        }

        return view('user.index', compact('arrUser'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $objService = new Service();
        $idRole = $objService->getPermission(self::ID_MODULE, 1, Session::get('id_role'));
        if (!empty($idRole)) {
            $idEvent = 1;
            $nomEvent = 'store';
            return view('user.gesUser', compact('idEvent', 'nomEvent'));
        } else {
            Session::flash('message', self::MSJ_PERMISSION);
            Session::flash('class', 'danger');
            return $this->index();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        $objService = new Service();
        $arrPar = $objService->normParUser($request->all());
        $objService->createUser($arrPar);
        $id_user = $objService->existUser($arrPar['email']);
        $objService->createUserRole($id_user);
        Session::flash('message', self::MSJ_REG_SUCCESS);
        Session::flash('class', 'success');
        return redirect('/user');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $objService = new Service();
        $idRole = $objService->getPermission(self::ID_MODULE, 2, Session::get('id_role'));
        $idRoleMod = $objService->getPermission(self::ID_MODULE, 5, Session::get('id_role'));
        $idRoleStatusMod = $objService->getPermission(self::ID_MODULE, 6, Session::get('id_role'));
        if (!empty($idRole) OR !empty($idRoleMod)) {
            $idEvent = 2;
            $nomEvent = 'update';
            $objUser = User::where('id_user', $id)->first();
            if (!empty($idRoleStatusMod)) {
                Session::set('estUser', $objService->getRow('App\EstUser', 'est_user'));
            }
            return view('user.gesUser', compact('idEvent', 'nomEvent', 'objUser', 'idRoleStatusMod'));
        } else {
            Session::flash('message', self::MSJ_PERMISSION);
            Session::flash('class', 'danger');
            return $this->index();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(UserEditRequest $request)
    {
        $objService = new Service();
        $arrPar = $objService->normParUser($request->all());
        $objService->updateUser($request['hdUser'], $arrPar);
        Session::flash('message', self::MSJ_UPD_SUCCESS);
        Session::flash('class', 'success');

        return redirect('/user');
    }


}
