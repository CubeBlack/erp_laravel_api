<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Pessoa;
use Illuminate\Testing\Fluent\AssertableJson;

class PessoasControllerTest extends TestCase
{
    //trait para resetar banco de dados
    use RefreshDatabase;


    public function test_pessoas_get_endpoint(): void
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
            //verificar estrutura e tipo a apartir do primeiro item
            $json->whereType('0.id', 'integer');
            $json->whereType('0.nome', 'string');
            $json->whereType('0.status', 'string');


            //verificar os tipos de forma mais pratica
            $json->whereAllType([
                '0.id'=> 'integer',
                '0.nome'=> 'string',
                '0.status'=> 'string'
            ]);

            //Verificar se a resposta tem os campos
            $json->hasAll(['0.id', '0.nome', '0.status']);

            

        });
    }
}
