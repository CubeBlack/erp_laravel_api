<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Cliente;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Models\Log;

class ClienteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_cliente_endpoint(): void
    {
        //Registra 3 
        $clinete = Cliente::factory(3)->create();

        //Pegar respsota em json
        $response = $this->getJson('/api/clientes');

        //Tratar o tipo de restposta
        $response->assertStatus(200);

        //Verificar quantidade respondida
        $response->assertJsonCount(3);


        //Verificar extrutura da resposat
        $response->assertJson(function(AssertableJson $json){

            //verificar os tipos de forma mais pratica
            $json->whereAllType([
                '0.id'=> 'integer',
                '0.status'=>'string',
                '0.pessoa_id'=> 'integer',
                '0.plano_id'=> 'integer'
            ]);

            //Verificar se a resposta tem os campos
            $json->hasAll([
                '0.id', 
                '0.status',
                '0.pessoa_id', 
                '0.plano_id'
            ]);

        });


        //verificar ordem
        $this->assertEquals(3, $response[0]['id']);
        $this->assertEquals(2, $response[1]['id']);
        $this->assertEquals(1, $response[2]['id']);
    }

    public function test_get_sigle_cliente(): void
    {
        //Registra 3 
        $cliente = Cliente::factory(1)->createOne();

        //Pegar respsota em json
        $response = $this->getJson('/api/clientes/' . $cliente->id);
       
        //Tratar o tipo de restposta
        $response->assertStatus(200);

        //Verificar extrutura da resposat
        $response->assertJson(function(AssertableJson $json) use ($cliente){
            //Verificar se a resposta tem os campos
            $json->hasAll([
                'id', 
                'status',
                'pessoa_id', 
                'plano_id',
                'created_at',
                'updated_at'
            ]);
            
            //verificar os tipos de forma mais pratica
            $json->whereAllType([
                'id'=> 'integer',
                'status'=>'string',
                'pessoa_id'=> 'integer',
                'plano_id'=> 'integer'
            ]);


            //Verificar valor por valor
            $json->whereAll([
                'id'=>$cliente->id,
                'status'=>$cliente->status,
                'pessoa_id'=>$cliente->pessoa_id,
                'plano_id'=>$cliente->plano_id
            ]);

        });
    }

    public function test_post_cliente(){

        $cliente = Cliente::factory(1)->makeOne()->toArray();
        $response = $this->postJson('/api/clientes', $cliente);
        $response->assertStatus(201);

        $response->assertJson(function(AssertableJson $json) use ($cliente){
            //
            $json->hasAll([
                'id', 
                'status',
                'pessoa_id', 
                'plano_id',
                'updated_at',
                'created_at'
            ]);

            //Fica faltando os valores gerados altomaticos
            $json->whereAll([
                'status'=>$cliente['status'],
                'pessoa_id'=>$cliente['pessoa_id'],
                'plano_id'=>$cliente['plano_id']
            ]);

        });

        //verificar se foi salvo o log
        $logs = Log::all();
        $this->assertCount(1, $logs);
    }

    public function test_put_Cliente(){
        Cliente::factory(1)->createOne();

        $cliente = [
            'plano_id' => 0,
            'status' => 'ATIVO'
        ];

        $response = $this->putJson('/api/clientes/1', $cliente);
        
        $response->assertStatus(200);

        $response->assertJson(function(AssertableJson $json) use ($cliente){
            $json->hasAll([
                'id', 
                'status',
                'pessoa_id', 
                'plano_id',
                'created_at',
                'updated_at'
            ]);

            $json->whereAll([
                'plano_id'=>$cliente['plano_id'],
                'status'=>$cliente['status']

            ]);

        });

        $logs = Log::all();
        $this->assertCount(1, $logs);
    }

    public function test_patch_cliente(){
        Cliente::factory(1)->createOne();

        $cliente = [
            'status' => 'INATIVO'
        ];
        $response = $this->patchJson('/api/clientes/1', $cliente);
        
        $response->assertStatus(200);

        $response->assertJson(function(AssertableJson $json) use ($cliente){
            $json->hasAll([
                'id', 
                'status',
                'pessoa_id', 
                'plano_id',
                'created_at',
                'updated_at'
            ]);

            //Verificar a penas os dados atualizados
            $json->whereAll([
                'status'=>$cliente['status']

            ]);

        });

        $logs = Log::all();
        $this->assertCount(1, $logs);
    }

    public function test_delete_pessoa_endpoint(){
        $response = $this->deleteJson('/api/clientes/1');
        $response->assertStatus(405);
    }
}
