<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 06/03/18
 * Time: 18:41
 */

namespace App\Repositories;


use App\Repositories\Mapper\PermissionMapper;
use Spatie\Permission\Models\Permission;

class PermissionRepo extends Repositorio
{

    public function __construct()
    {
        $this->gateway = new Permission();
        $this->mapper = new PermissionMapper();
    }

    function model()
    {
        return 'App\Repositories\PermissionRepo';
    }
}