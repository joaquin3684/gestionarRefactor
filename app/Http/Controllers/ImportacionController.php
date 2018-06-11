<?php

namespace App\Http\Controllers;

use App\Repositories\AfiliadoRepo;
use Illuminate\Http\Request;

class ImportacionController extends Controller
{
    public function importarAfiliados(Request $request)
    {
        foreach ($request->all() as $afiliado)
        {
            $repo = new AfiliadoRepo();
            $repo->create($afiliado);

        }
    }
}
