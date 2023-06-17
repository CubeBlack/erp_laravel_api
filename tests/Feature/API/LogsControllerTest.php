<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Log;
use Illuminate\Testing\Fluent\AssertableJson;

class LogsControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_get_logs(): void
    {
        $logs = Log::factory(3)->create();

        $response = $this->getJson('/api/logs');

        $response->assertStatus(200);
        $response->assertJsonCount(3);

        $response->assertJson(function(AssertableJson $json) use ($logs){
            $json->whereType('0.titulo', 'string');
            $json->whereType('0.descricao', 'string');

            $log = $logs->last();

            $json->whereAll([
                '0.titulo' =>$log->titulo,
                '0.descricao' =>$log->descricao
            ]);
        });

        //verificar ordem
        $this->assertEquals(3, $response[0]['id']);
        $this->assertEquals(2, $response[1]['id']);
        $this->assertEquals(1, $response[2]['id']);
    }


}
