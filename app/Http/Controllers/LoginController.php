<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Service\Service;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App;
use Auth;
use Session;
use Redirect;
use Socialite;

class LoginController extends Controller
{
    var $arrEstUser = [1, 2];
    const EST_ACTIVE = 1;
    const EST_INACTIVE = 2;
    const  MSJ_ERROR = 'User or Password invalid';
    const MSJ_INATIVE_USER = 'User is inactive, please contact with your administrator';
    const PASS_FACEBOOK = 'faceLogin;';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Redirect::to('/');
    }


    /**
     * This method validates user access
     *
     * @param LoginRequest $request
     * @return string
     */
    public function store(LoginRequest $request)
    {
        $arrParms['email'] = $request['txtEmail'];
        $arrParms['password'] = $request['txtPassword'];

        $arrReturn = $this->validateAccess($arrParms);
        if ($arrReturn['codResp'] == 1) {
            $objService = new Service();
            $objPermission = $objService->getPermissionByRole(Auth::user()->id_user);
            Session::set('permission', $objPermission);
            Session::set('nameUser', Auth::user()->name_user);
            return Redirect::to('/user');
        }

        Session::flash('message', $arrReturn['message']);
        Session::flash('class', $arrReturn['class']);
        return Redirect::to('/');
    }

    public function show()
    {
        Auth::logout();
        return Redirect::to('/');
    }

    /**
     * This method return codResp according to est user
     *
     * @param array $arrParms
     * @return array
     */
    private function validateAccess($arrParms)
    {
        $arrReturn = array('codResp' => 0, 'message' => self::MSJ_ERROR, 'class' => 'danger');
        $arrParms['id_est_user'] = self::EST_ACTIVE;
        if (Auth::attempt($arrParms)) {
            $arrReturn = array('codResp' => 1);
        }

        $arrParms['id_est_user'] = self::EST_INACTIVE;
        if (Auth::attempt($arrParms)) {
            $arrReturn = array('codResp' => 0, 'message' => self::MSJ_INATIVE_USER, 'class' => 'warning');
        }

        return $arrReturn;

    }

    /**
     * Redirect the user to the facebook authentication page.
     *
     * @return Response
     */
    public function redirectToProviderFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallbackFacebook()
    {

        try {
            $user = Socialite::driver('facebook')->user();
        } catch (\Exception $e) {
            return Redirect::to('/');
        }

        $objService = new Service();
        if (!$objService->existUser($user->email)) {
            $arrPar['name'] = $user->name;
            $arrPar['email'] = $user->email;
            $arrPar['password'] = self::PASS_FACEBOOK;
            $arrPar = $objService->normParUser($arrPar);
            $objService->createUser($arrPar);
            $id_user = $objService->existUser($user->email);
            $objService->createUserRole($id_user);
        }
        Auth::attempt(['email' => $user->email, 'password' => self::PASS_FACEBOOK]);
        $objService = new Service();
        $objPermission = $objService->getPermissionByRole(Auth::user()->id_user);
        Session::set('permission', $objPermission);
        Session::set('nameUser', $user->name);
        return Redirect::to('/user');
    }


}
