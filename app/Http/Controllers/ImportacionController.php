<?php

namespace App\Http\Controllers;

use App\Repositories\AfiliadoRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImportacionController extends Controller
{
    public function importarAfiliados(Request $request)
    {
        DB::transaction(function() use ($request) {

            foreach ($request->all() as $afiliado) {
                $repo = new AfiliadoRepo();
                $repo->create($afiliado);

            }
        });
    }
}
