<?php

namespace App\Http\Controllers;

use App\Http\Service\Service;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\MatrizRequest;
use App\Http\Requests\FrontRequest;
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
        return view('matriz.index', compact('arrResp'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(FrontRequest $request)
    {
        $validaMatriz = ValidaMatrizService::validaParmBasico($request->all());
        if ($validaMatriz['codResp'] == 0) {
            Session::flash('message', $validaMatriz['msj']);
            Session::flash('class', 'danger');
            return Redirect::to('/');
        }

        $objService = new Service();
        $objService->existeFileJson($request->all());
        return $this->index();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\MatrizRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(MatrizRequest $request)
    {
        $validaMatriz = ValidaMatrizService::validaParmOperacion($request['txtOpeCaso']);
        if ($validaMatriz['codResp'] == 0) {
            Session::flash('message', $validaMatriz['msj']);
            Session::flash('class', 'danger');
            return $this->index();
        }

        $objService = new Service();
        $arrResp = $objService->validaOperacion($request['txtOpeCaso']);
        if ($arrResp['codResp'] == 0) {
            Session::flash('message', $arrResp['msj']);
            Session::flash('class', 'danger');
        }
        $this->arrResp = $arrResp['operacion'];
        return $this->index();
    }

}
