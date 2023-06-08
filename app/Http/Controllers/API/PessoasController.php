<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pessoa;

class PessoasController extends Controller
{
    public function __construct(private Pessoa $pessoa){

    }


    public function index(){
        return response()->json($this->pessoa->all());
    }

    public function show($id){
        $pessoa = $this->pessoa->find($id);
        return response()->json($pessoa);
    
    }

    public function store(Request $request){
        $pessoa = $this->pessoa->create($request->all());
        return response()->json($pessoa, 201);
    
    }


    public function update($id, Request $request){
        $pessoa = $this->pessoa->find($id);
        $pessoa->update($request->all());
        return response()->json($pessoa);
    
    }

}
