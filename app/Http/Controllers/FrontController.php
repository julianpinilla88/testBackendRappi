<?php

namespace App\Http\Controllers;

use App\Http\Service\Service;
use App\Http\Service\ValidaMatrizService;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arrResp = [];
        return view('index', compact('arrResp'));
    }
}
