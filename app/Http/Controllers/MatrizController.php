<?php

namespace App\Http\Controllers;

use App\Http\Service\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Service\ValidaMatrizService;
use App;
use Redirect;

class MatrizController extends Controller
{
    var $arrResp = [];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arrResp = $this->arrResp;
        return view('index', compact('arrResp'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valida = ValidaMatrizService::validaParm($request['hdNameFile']);

        if ($valida['codResp'] == 0) {
            Session::flash('message', $valida['msj']);
            Session::flash('class', 'danger');
            return Redirect::to('/');
        }

        $this->arrResp = $valida['resp'];
        return $this->index();
    }

}
