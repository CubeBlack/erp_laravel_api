<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Pessoa;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Models\Log;

class PessoasControllerTest extends TestCase
{
    //trait para resetar banco de dados
    use RefreshDatabase;

    public function test_get_pessoas_endpoint(): void
    {
        //Registra 3 pessoas para testar
        $pessoas = Pessoa::factory(3)->create();

        //Pegar respsota em json
        $response = $this->getJson('/api/pessoas');

        //exibir resposta
        //dd($response->baseResponse);
        
        //Tratar o tipo de restposta
        $response->assertStatus(200);

        //Verificar quantidade respondida
        $response->assertJsonCount(3);


        //Verificar extrutura da resposat
        $response->assertJson(function(AssertableJson $json){

            //verificar os tipos de forma mais pratica
            $json->whereAllType([
                '0.id'=> 'integer',
                '0.nome'=> 'string',
                '0.status'=> 'string',
                '0.pessoa_tipo'=>'string',
                '0.cpf'=>'string',
                '0.cnpj'=>'string'
            ]);

            //Verificar se a resposta tem os campos
            $json->hasAll([
                '0.id', 
                '0.nome', 
                '0.status',
                '0.pessoa_tipo',
                '0.cpf',
                '0.cnpj'
            ]);

        });


        //verificar ordem
        $this->assertEquals(3, $response[0]['id']);
        $this->assertEquals(2, $response[1]['id']);
        $this->assertEquals(1, $response[2]['id']);
    }

    public function test_get_sigle_pessoas_endpoint(): void
    {
        //Registra 3 pessoas para testar
        $pessoa = Pessoa::factory(1)->createOne();

        //Pegar respsota em json
        $response = $this->getJson('/api/pessoas/' .$pessoa->id);


        
        //Tratar o tipo de restposta
        $response->assertStatus(200);



        //Verificar extrutura da resposat
        $response->assertJson(function(AssertableJson $json) use ($pessoa){
            //Verificar se a resposta tem os campos
            $json->hasAll([
                'id', 
                
                'nome', 
                'status', 
                'pessoa_tipo',
                'cpf',
                'cnpj',
                
                'created_at', 
                'updated_at'
            ]);
            
            //verificar os tipos de forma mais pratica
            $json->whereAllType([
                'id'=> 'integer',

                'nome'=> 'string',
                'status'=> 'string',
                'pessoa_tipo'=>'string',
                'cpf'=>'string',
                'cnpj'=>'string'
            ]);


            //Verificar valor por valor
            $json->whereAll([
                'id'=>$pessoa->id,
                'nome'=>$pessoa->nome,
                'status'=>$pessoa->status,
                'pessoa_tipo'=>$pessoa->pessoa_tipo,
                'cpf'=>$pessoa->cpf,
                'cnpj'=>$pessoa->cnpj
            ]);

        });
    }

    public function test_post_pessoas_endpoint(){

        $pessoa = Pessoa::factory(1)->makeOne()->toArray();
        $response = $this->postJson('/api/pessoas', $pessoa);
        $response->assertStatus(201);

        $response->assertJson(function(AssertableJson $json) use ($pessoa){
            //
            $json->hasAll([
                'id', 
                
                'nome', 
                'status', 
                'pessoa_tipo',
                'cpf',
                'cnpj',
                
                'created_at', 
                'updated_at'
            ]);

            //Fica faltando os valores gerados altomaticos
            $json->whereAll([
                'nome'=>$pessoa['nome'],
                'status'=>$pessoa['status'],
                'pessoa_tipo'=>$pessoa['pessoa_tipo'],
                'cpf'=>$pessoa['cpf'],
                'cnpj'=>$pessoa['cnpj']
            ]);

        });

        //verificar se foi salvo o log
        $logs = Log::all();
        $this->assertCount(1, $logs);
    }

    public function test_put_pessoas_endpoint(){
        Pessoa::factory(1)->createOne();

        $pessoa = [
            'nome' => 'Atualizando Pessoa...',
            'status' => 'ATIVO'
        ];
        $response = $this->putJson('/api/pessoas/1', $pessoa);
        
        $response->assertStatus(200);

        $response->assertJson(function(AssertableJson $json) use ($pessoa){
            $json->hasAll([
                'id', 
                
                'nome', 
                'status', 
                'pessoa_tipo',
                'cpf',
                'cnpj',
                
                'created_at', 
                'updated_at'
            ]);

            $json->whereAll([
                'nome'=>$pessoa['nome'],
                'status'=>$pessoa['status']

            ]);

        });

        $logs = Log::all();
        $this->assertCount(1, $logs);
    }

    public function test_patch_pessoas_endpoint(){
        Pessoa::factory(1)->createOne();

        $pessoa = [
            'nome' => 'Atualizando Pessoa path...'
        ];
        $response = $this->patchJson('/api/pessoas/1', $pessoa);
        
        $response->assertStatus(200);

        $response->assertJson(function(AssertableJson $json) use ($pessoa){
            $json->hasAll([
                'id', 
                
                'nome', 
                'status', 
                'pessoa_tipo',
                'cpf',
                'cnpj',
                
                'created_at', 
                'updated_at'
            ]);

            //Verificar a penas os dados atualizados
            $json->whereAll([
                'nome'=>$pessoa['nome']

            ]);

        });

        $logs = Log::all();
        $this->assertCount(1, $logs);
    }

    public function test_delete_pessoa_endpoint(){
        $response = $this->deleteJson('/api/pessoas/1');
        $response->assertStatus(405);
    }



}
