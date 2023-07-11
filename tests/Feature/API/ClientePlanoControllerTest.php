<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\ClientePlano;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Models\Log;

class ClientePlanoControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_get_cliente_planos(): void
    {
        //criar 3 registros
        $planos = ClientePlano::factory(3)->create();

        //fazer requisição
        $response = $this->get('/api/clienteplanos');

        //Verificar se tem resposta
        $response->assertStatus(200);

        //verificar se esta correta a quanidade criada
        $response->assertJsonCount(3);

        //verificar por item
        $response->assertJson(function(AssertableJson $json) use ($planos){
            //tipo de dado
            $json->whereType('0.nome', 'string');
            $json->whereType('0.status', 'string');
            $json->whereType('0.valor', 'double');

            //comparar os valores
            $plano = $planos->last();

            $json->whereAll([
                '0.nome' =>$plano->nome,
                '0.status' =>$plano->status,
                '0.valor' =>$plano->valor
            ]);
        });

        //verificar ordem
        $this->assertEquals(3, $response[0]['id']);
        $this->assertEquals(2, $response[1]['id']);
        $this->assertEquals(1, $response[2]['id']);
    }

    public function test_get_single_cliente_plano(): void
    {
        //Registra 3 pessoas para testar
        $plano = ClientePlano::factory(1)->createOne();

        //Pegar respsota em json
        $response = $this->getJson('/api/clienteplanos/' .$plano->id);

       
        //Tratar o tipo de restposta
        $response->assertStatus(200);



        //Verificar extrutura da resposat
        $response->assertJson(function(AssertableJson $json) use ($plano){
            //Verificar se a resposta tem os campos
            $json->hasAll(['id', 'nome', 'status', 'valor', 'created_at', 'updated_at']);
            
            //verificar os tipos de forma mais pratica
            $json->whereAllType([
                'id'=> 'integer',
                'nome'=> 'string',
                'status'=> 'string',
                'valor'=> 'double'
            ]);


            //Verificar valor por valor
            $json->whereAll([
                'id'=>$plano->id,
                'nome'=>$plano->nome,
                'status'=>$plano->status,
                'valor'=>$plano->valor
            ]);

        });
    }

    public function test_post_cliente_plano(){
        //criar registro
        $plano = ClientePlano::factory(1)->makeOne()->toArray();

        //fazer solicitação
        $response = $this->postJson('/api/clienteplanos', $plano);

        //verificar codigo de resposata
        $response->assertStatus(201);

        //verificar dados da resposta
        $response->assertJson(function(AssertableJson $json) use ($plano){
            //
            $json->hasAll(['id', 'nome', 'status', 'valor', 'created_at', 'updated_at']);

            //Fica faltando os valores gerados altomaticos
            $json->whereAll([
                'nome'=>$plano['nome'],
                'status'=>$plano['status'],
                'valor'=>$plano['valor']
            ])->etc();

        });

        //verificar se foi salvo o log
        $logs = Log::all();
        $this->assertCount(1, $logs);
    }

    public function test_put_cliente_plano(){
        ClientePlano::factory(1)->createOne();

        $plano = [
            'nome' => 'Atualizando Pessoa...',
            'status' => 'ATIVO',
            'valor' => 2.99
        ];
        $response = $this->putJson('/api/clienteplanos/1', $plano);
        
        $response->assertStatus(200);

        $response->assertJson(function(AssertableJson $json) use ($plano){
            $json->hasAll(['id', 'nome', 'status', 'valor', 'created_at', 'updated_at']);

            $json->whereAll([
                'nome'=>$plano['nome'],
                'status'=>$plano['status'],
                'valor'=>$plano['valor']
            ])->etc();

        });

        $logs = Log::all();
        $this->assertCount(1, $logs);
    }

    public function test_patch_cliente_plano(){
        ClientePlano::factory(1)->createOne();

        $plano = [
            'nome' => 'Atualizando Pessoa path...'
        ];
        $response = $this->patchJson('/api/clienteplanos/1', $plano);
        
        $response->assertStatus(200);

        $response->assertJson(function(AssertableJson $json) use ($plano){
            $json->hasAll(['id', 'nome', 'status', 'valor', 'created_at', 'updated_at']);
            $json->where('nome', $plano['nome']);

        });

        $logs = Log::all();
        $this->assertCount(1, $logs);
    }

    public function test_delete_plano_cliente(){
        $response = $this->deleteJson('/api/clienteplanos/1');
        $response->assertStatus(405);
    }
}
