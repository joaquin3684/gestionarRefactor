<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FarmaciaControllerTest extends TestCase
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
            'NOMBRE' => 1,
            'LOCALIDAD' => 1,
            'latitude' => 1,
            'longitude' => 1,
            'TELEFONO' => 1,
            'DIRECCION' => 1,
            'obrasSociales' => [1, 2],

        ];
    }

    public function dataUpdate()
    {
        return [
            'NOMBRE' => 1,
            'LOCALIDAD' => 1,
            'latitude' => 1,
            'longitude' => 1,
            'TELEFONO' => 1,
            'DIRECCION' => 1,
            'obrasSociales' => [1],
        ];
    }

    public function setUp()
    {

        parent::setUp();
        $this->seed("SecuritySeed");
        $data= array("name" => "1", "password" => "1");
        $response = $this->json('POST','login', $data);
        $this->token = $response->json()['data']['token'];


    }

    public function testStore()
    {
        $data = $this->dataStore();
        $response = $this->post("farmacia", $data, ['Authorization' => 'Bearer '.$this->token]);


        unset($data['obrasSociales']);
        $this->assertDatabaseHas('Farmacias', $data);
        $this->assertDatabaseHas('Farmacia_obra_social', ['id_farmacia' => 1, 'id_obra_social' => 2]);
        $this->assertDatabaseHas('Farmacia_obra_social', ['id_farmacia' => 1, 'id_obra_social' => 1]);

    }

    /**
     * @expectedException App\Exceptions\NoTieneAccesoAEstaObraSocialException
     */
    public function testPostSinPermisoAObraSocial()
    {
        $data = $this->dataStore();
        $data['obrasSociales'][2] = 3;
        $response = $this->post("farmacia", $data, ['Authorization' => 'Bearer '.$this->token]);
    }


    public function testUpdate()
    {
        $data = $this->dataStore();
        $dataUpdate = $this->dataUpdate();

        $response = $this->post("farmacia", $data, ['Authorization' => 'Bearer '.$this->token]);

        $response = $this->put("farmacia/1", $dataUpdate, ['Authorization' => 'Bearer '.$this->token]);

        unset($dataUpdate['especialidades']);
        unset($dataUpdate['obrasSociales']);
        $this->assertDatabaseHas('Farmacias', $dataUpdate);
        $this->assertDatabaseHas('Farmacia_obra_social', ['id_farmacia' => 1, 'id_obra_social' => 1]);
        $this->assertDatabaseMissing('Farmacia_obra_social', ['id_farmacia' => 1, 'id_obra_social' => 2]);

    }

    /**
     * @expectedException App\Exceptions\NoTieneAccesoAEstaObraSocialException
     */
    public function testUpdateSinPermisoAObraSocial()
    {
        $data = $this->dataStore();
        $dataUpdate = $this->dataUpdate();
        $dataUpdate['obrasSociales'][2] = 3;

        $response = $this->post("farmacia", $data, ['Authorization' => 'Bearer '.$this->token]);
        $response = $this->put("farmacia/1", $dataUpdate, ['Authorization' => 'Bearer '.$this->token]);


    }
}
