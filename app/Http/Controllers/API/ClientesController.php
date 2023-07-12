<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cliente;
use App\Models\Log;

class ClientesController extends Controller
{
    public function __construct(private Cliente $cliente, private Log $log){

    }

    public function index(){
        return response()->json($this->cliente->orderBy('id', 'desc')->get());
    }

    public function show($id){
        $cliente = $this->cliente->find($id);
        return response()->json($cliente);
    
    }

    public function store(Request $request){
        //Salvar 
        $cliente = $this->cliente->create($request->all());

        //salvar o log
        $this->log->titulo = "Novo Cliente: {$cliente->nome}({$cliente->id})";
        $this->log->descricao = $this->cliente->toJson();
        $this->log->save();

        //retornar a pessoa salva
        return response()->json($cliente, 201);
    
    }

    public function update($id, Request $request){
        //Pega 
        $cliente = $this->cliente->find($id);

        //atualizar
        $cliente->update($request->all());

        //salvar o log
        $this->log->titulo = "Plano de cliente Alterado: {$cliente->nome}({$cliente->id})";
        $this->log->descricao = json_encode($cliente->getChanges());
        $this->log->save();

        return response()->json($cliente);
    }
    
}
