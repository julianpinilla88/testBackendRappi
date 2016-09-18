<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use App\User;
use App;
use Auth;
use Session;
use Redirect;
use Socialite;

class PasswordController extends Controller
{
    const MSJ_UPD_SUCCESS = 'The password user was updated succesfully';

    public function __construct(Redirect $redirect)
    {
        if (Auth::guest()) {
            $redirect::to('/')->send();
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
        $idUser = $id;
        return view('user.password', compact('idUser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PasswordRequest $request)
    {
        $arrPar['password'] = bcrypt($request['txtPassword']);
        $arrPar['modified_date'] = date('Y-m-d H:i:s');
        User::where('id_user', $request['hdUser'])->update($arrPar);

        Session::flash('message', self::MSJ_UPD_SUCCESS);
        Session::flash('class', 'success');

        return redirect('/user');
    }

}
