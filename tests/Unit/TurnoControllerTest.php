<?php

namespace Tests\Unit;

use App\Turno;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TurnoControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    use DatabaseMigrations;
    private $token;
    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->seed("SecuritySeed");
        $data= array("name" => "1", "password" => "1");
        $response = $this->json('POST','login', $data);
        $this->token = $response->json()['data']['token'];
        factory(\App\Especialidad::class)->create();
        factory(\App\Especialidad::class)->create();
        factory(\App\Climed::class)->create();
        factory(\App\Climed::class)->create();
        factory(\App\Solicitud::class)->create();
    }

    public function dataStore()
    {
        return [
            'IDSOLICITUD' => 1,
            'FECHAT' => "2017-02-03",
            'HORAT' => "20:08:00",
            'CONFIRMACION' => 1,
            'MEDICOASIGNADO' => "lasdjflaskj"
        ];
    }

    public function dataUpdate()
    {
        return [
            'IDSOLICITUD' => 1,
            'FECHAT' => "2017-02-05",
            'HORAT' => "21:08:00",
            'CONFIRMACION' => 2,
            'MEDICOASIGNADO' => "fdsasf"
        ];
    }


    public function testCreate()
    {
        $data = $this->dataStore();

        $response = $this->post('turno', $data, ['Authorization' => 'Bearer '.$this->token]);
        
        $this->assertDatabaseHas('Turnos', $data);
        $this->assertDatabaseHas('Solicitudes', ['IDS' => 1, 'ESTADO' => 'En Espera']);
    }

    public function testUpdate()
    {
        $data = $this->dataStore();
        $response = $this->post('turno', $data, ['Authorization' => 'Bearer '.$this->token]);

        $data = $this->dataUpdate();
        $data['id'] = 1;
        $response = $this->post('turno/modificar', $data, ['Authorization' => 'Bearer '.$this->token]);

        unset($data['id']);
        $this->assertDatabaseHas('Turnos', $data);

    }

    /**
     * @expectedException App\Exceptions\NoTieneAccesoAEstaObraSocialException
     */
    public function testCreateSinPermisoObraSocial()
    {
        $data = $this->dataStore();
        $af = factory(\App\Afiliado::class)->create(['IDOBRASOCIAL' => 3, 'DNI' => 47]);
        $sol = factory(\App\Solicitud::class)->create(['DNISOLICITANTE' => $af->DNI, 'IDCLIMED' => 1, 'ESPECIALIDAD' => 1 ]);
        $data['IDSOLICITUD'] = $sol->IDS;

        $response = $this->post('turno', $data, ['Authorization' => 'Bearer '.$this->token]);
    }

    /**
     * @expectedException App\Exceptions\NoTieneAccesoAEstaObraSocialException
     */
    public function testUpdateSinPermisoObraSocial()
    {
        $data = $this->dataStore();
        $af = factory(\App\Afiliado::class)->create(['IDOBRASOCIAL' => 3, 'DNI' => 47]);
        $sol = factory(\App\Solicitud::class)->create(['DNISOLICITANTE' => $af->DNI, 'IDCLIMED' => 1, 'ESPECIALIDAD' => 1 ]);
        $data['IDSOLICITUD'] = $sol->IDS;
        Turno::create($data);

        $data = $this->dataUpdate();
        $data['id'] = 1;
        $response = $this->post('turno/modificar', $data, ['Authorization' => 'Bearer '.$this->token]);

    }
}
