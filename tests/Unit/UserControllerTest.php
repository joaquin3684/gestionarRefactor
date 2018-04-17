<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserControllerTest extends TestCase
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
        return array(
            "name" => 23,
            "password" => 23,
            "email" => 23,
            "id_perfil" => 1,
            "obrasSociales" => [1,2]
        );
    }

    public function dataUpdate()
    {
        return array(
            "name" => 233,
            "password" => 233,
            "email" => 233,
            "id_perfil" => 1,
            "obrasSociales" => [1]
        );
    }

    public function setUp()
    {

        parent::setUp();
        $this->seed("SecuritySeed");
        $data= array("name" => "1", "password" => "1");
        $response = $this->json('POST','login', $data);
        $this->token = $response->json()['data']['token'];

    }
    public function testCreate()
    {
        $data = $this->dataStore();

        $response = $this->post('user', $data, ['Authorization' => 'Bearer '.$this->token]);

        $pass = $data['password'];
        unset($data['obrasSociales']);
        unset($data['password']);
        $us = User::find(3);
        $this->assertDatabaseHas('Usuarios', $data);
        $this->assertDatabaseHas('Usuario_obra_social', ['id_usuario' => 3, 'id_obra_social' => 1]);
        $this->assertDatabaseHas('Usuario_obra_social', ['id_usuario' => 3, 'id_obra_social' => 2]);
        $this->assertTrue(Hash::check($pass, $us->password));
    }

    public function testUpdate()
    {
        $data = $this->dataStore();
        $response = $this->post('user', $data, ['Authorization' => 'Bearer '.$this->token]);

        $data = $this->dataUpdate();

        //aca va el 3  por la inicializacion de los elementos en la base de datos
        $response = $this->put('user/3', $data, ['Authorization' => 'Bearer '.$this->token]);

        unset($data['obrasSociales']);
        unset($data['password']);
        $this->assertDatabaseHas('Usuarios', $data);
        $this->assertDatabaseHas('Usuario_obra_social', ['id_usuario' => 3, 'id_obra_social' => 1]);
        $this->assertDatabaseMissing('Usuario_obra_social', ['id_usuario' => 3, 'id_obra_social' => 2]);

    }

    public function testCambiarPassword()
    {
        $data = $this->dataStore();
        $response = $this->post('user', $data, ['Authorization' => 'Bearer '.$this->token]);

        $data = array('password' => 456, 'id' => 3);
        $response = $this->post('user/cambiarPassword', $data, ['Authorization' => 'Bearer '.$this->token]);

        $us = User::find(3);
        $this->assertTrue(Hash::check($data['password'], $us->password));
    }

    /**
     * @expectedException App\Exceptions\NoTieneAccesoAEstaObraSocialException
     */
    public function testUpdateSinPermisoAObraSocial()
    {
        $data = $this->dataStore();
        $dataUpdate = $this->dataUpdate();
        $dataUpdate['obrasSociales'][2] = 3;

        $response = $this->post("user", $data, ['Authorization' => 'Bearer '.$this->token]);
        $response = $this->put("user/3", $dataUpdate, ['Authorization' => 'Bearer '.$this->token]);


    }

    /**
     * @expectedException App\Exceptions\NoTieneAccesoAEstaObraSocialException
     */
    public function testCreateSinPermisoAObraSocial()
    {
        $data = $this->dataStore();
        $data['obrasSociales'][2] = 3;

        $response = $this->post("user", $data, ['Authorization' => 'Bearer '.$this->token]);


    }
}
