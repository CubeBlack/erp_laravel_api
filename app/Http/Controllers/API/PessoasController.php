<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pessoa;

class PessoasController extends Controller
{
    //Passar model como parametro
    public function index(Pessoa $pessoa){
        return response()->json($pessoa->all());
    }
}
