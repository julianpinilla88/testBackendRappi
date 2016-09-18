<?php

namespace App\Http\Controllers;

use App\Http\Service\Service;
use App\RoleXUser;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Session;
use Redirect;
use Socialite;

class RoleXUserController extends Controller
{
    const MSJ_UPD_SUCCESS = 'The user-role was updated succesfully';
    const MSJ_PERMISSION = 'You don\'t have permissions for execute this action';
    const ID_MODULE = 2;

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
        $idMod = $objService->getPermission(self::ID_MODULE, 2, Session::get('id_role'));
        if (!empty($idRole)) {
            Session::set('mod',$idMod);
            $arrUserXRole = $objService->getUserXRole();
            return view('role.index', compact('arrUserXRole'));
        } else {
            Session::flash('message', self::MSJ_PERMISSION );
            Session::flash('class', 'success');
            return redirect('/user');
        }
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
        if (!empty($idRole)) {
            $objRole = $objService->getRow('App\Role', 'role');
            return view('role.roleXPermisiion', compact('objRole', 'id'));
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $arrPar['id_role'] = $request['optRole'];
        $arrPar['modified_date'] = date('Y-m-d H:i:s');
        RoleXUser::where('id_role_xuser', $request['hdUserRole'])->update($arrPar);

        Session::flash('message', self::MSJ_UPD_SUCCESS);
        Session::flash('class', 'success');

        return redirect('/role');
    }
}
