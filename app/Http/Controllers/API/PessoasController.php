<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pessoa;
use App\Models\Log;

class PessoasController extends Controller
{
    public function __construct(private Pessoa $pessoa, private Log $log){

    }


    public function index(){
        return response()->json($this->pessoa->all());
    }

    public function show($id){
        $pessoa = $this->pessoa->find($id);
        return response()->json($pessoa);
    
    }

    public function store(Request $request){
        //Salvar a pessoa
        $pessoa = $this->pessoa->create($request->all());

        //salvar o log
        $this->log->titulo = 'Novo cadastro: ' . $pessoa->id .', '. $pessoa->nome;
        $this->log->descricao = $this->pessoa->toJson();
        $this->log->save();

        //retornar a pessoa salva
        return response()->json($pessoa, 201);
    
    }


    public function update($id, Request $request){
        //Pega a pessoa
        $pessoa = $this->pessoa->find($id);

        //atualizar a pessoa
        $pessoa->update($request->all());

        //salvar o log
        $this->log->titulo = 'Cadastro Alterado: ' . $pessoa->id .', '. $pessoa->nome;
        $this->log->descricao = json_encode($pessoa->getChanges());
        $this->log->save();

        return response()->json($pessoa);
    
    }

}
