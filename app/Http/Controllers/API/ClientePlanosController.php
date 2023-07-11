<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ClientePlano;
use App\Models\Log;

class ClientePlanosController extends Controller
{
    public function __construct(private ClientePlano $plano, private Log $log){

    }

    public function index(){
        return response()->json($this->plano->orderBy('id', 'desc')->get());
        //return [];
    }

    public function show($id){
        $plano = $this->plano->find($id);
        return response()->json($plano);
    
    }

    public function store(Request $request){
        //Salvar 
        $plano = $this->plano->create($request->all());

        //salvar o log
        $this->log->titulo = "Novo plano de cliente: {$plano->nome}({$plano->id})";
        $this->log->descricao = $this->plano->toJson();
        $this->log->save();

        //retornar a pessoa salva
        return response()->json($plano, 201);
    
    }

    public function update($id, Request $request){
        //Pega 
        $plano = $this->plano->find($id);

        //atualizar
        $plano->update($request->all());

        //salvar o log
        $this->log->titulo = "Plano de cliente Alterado: {$plano->nome}({$plano->id})";
        $this->log->descricao = json_encode($plano->getChanges());
        $this->log->save();

        return response()->json($plano);
    
    }
}
