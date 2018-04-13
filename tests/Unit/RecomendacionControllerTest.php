<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RecomendacionControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    use DatabaseMigrations;
    private $token;
    public function dataStore()
    {
        return [
            'NOMBRE' => 'required',
            'APELLIDO' => 'required',
            'NRO' => 1,
        ];
    }



    public function setUp()
    {

        parent::setUp();
        $this->seed("SecuritySeed");
        $data= array("name" => "afiliado", "password" => "afiliado");
        $response = $this->json('POST','login', $data);
        $this->token = $response->json()['data']['token'];

    }

    public function testCreate()
    {
        $data = $this->dataStore();
        $response = $this->post("recomendacion", $data, ['Authorization' => 'Bearer '.$this->token]);

        $data['FECHA'] = Carbon::today()->toDateString();
        $data['CONTACTADO'] = 0;
        $this->assertDatabaseHas('Recomendaciones', $data);
    }

    public function testContactado()
    {
        $storeData = $this->dataStore();
        $data = array("ids" => array(1, 2, 3));
        $response = $this->post("recomendacion", $storeData, ['Authorization' => 'Bearer '.$this->token]);
        $response = $this->post("recomendacion", $storeData, ['Authorization' => 'Bearer '.$this->token]);
        $response = $this->post("recomendacion", $storeData, ['Authorization' => 'Bearer '.$this->token]);

        $response = $this->post("recomendacion/contactado", $data, ['Authorization' => 'Bearer '.$this->token]);

        $this->assertDatabaseHas('Recomendaciones', ['ID' => 1, 'CONTACTADO' => 1]);
        $this->assertDatabaseHas('Recomendaciones', ['ID' => 2, 'CONTACTADO' => 1]);
        $this->assertDatabaseHas('Recomendaciones', ['ID' => 3, 'CONTACTADO' => 1]);
    }
}
