<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ClimedControllerTest extends TestCase
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
            'ZONA' => 1,
            'PARTICULAR' => 1,
            'DIRECCION' => 1,
            'latitude' => 1,
            'longitude' => 1,
            'TELEFONO' => 1,
            'especialidades' => [1,2],
            'obrasSociales' => [1,2],
        ];
    }

    public function dataUpdate()
    {
        return [
            'NOMBRE' => 2,
            'LOCALIDAD' => 3,
            'ZONA' => 2,
            'PARTICULAR' => 2,
            'DIRECCION' => 2,
            'latitude' => 2,
            'longitude' => 2,
            'TELEFONO' => 2,
            'especialidades' => [1],
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
        factory(\App\Especialidad::class)->create();
        factory(\App\Especialidad::class)->create();

    }

    public function testStore()
    {
        $data = $this->dataStore();
        $response = $this->post("climed", $data, ['Authorization' => 'Bearer '.$this->token]);


        unset($data['especialidades']);
        unset($data['obrasSociales']);
        $this->assertDatabaseHas('Climed', $data);
        $this->assertDatabaseHas('ClimedEsp', ['IDCLIMED' => 1, 'IDESP' => 1]);
        $this->assertDatabaseHas('ClimedEsp', ['IDCLIMED' => 1, 'IDESP' => 2]);
        $this->assertDatabaseHas('Climed_obra_social', ['IDCLIMED' => 1, 'IDOBRASOCIAL' => 1]);
        $this->assertDatabaseHas('Climed_obra_social', ['IDCLIMED' => 1, 'IDOBRASOCIAL' => 2]);

    }

    public function testUpdate()
    {
        $data = $this->dataStore();
        $dataUpdate = $this->dataUpdate();
        $response = $this->post("climed", $data, ['Authorization' => 'Bearer '.$this->token]);

        $response = $this->put("climed/1", $dataUpdate, ['Authorization' => 'Bearer '.$this->token]);

        unset($dataUpdate['especialidades']);
        unset($dataUpdate['obrasSociales']);
        $this->assertDatabaseHas('Climed', $dataUpdate);
        $this->assertDatabaseHas('ClimedEsp', ['IDCLIMED' => 1, 'IDESP' => 1]);
        $this->assertDatabaseMissing('ClimedEsp', ['IDCLIMED' => 1, 'IDESP' => 2]);

        $this->assertDatabaseHas('Climed_obra_social', ['IDCLIMED' => 1, 'IDOBRASOCIAL' => 1]);
        $this->assertDatabaseMissing('Climed_obra_social', ['IDCLIMED' => 1, 'IDOBRASOCIAL' => 2]);

    }
}
