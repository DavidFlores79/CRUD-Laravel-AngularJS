<?php

namespace App\Traits;

use App\Models\TipoFormulario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait FormularioTrait
{
    public function getCamposTabla(Request $request) {
        //return $request;
        //validar request
        $rules = [
            'id' => 'required|exists:tipo_formularios,id',
        ];
        $this->validate($request, $rules);
        
        $form = TipoFormulario::findOrFail($request->input('id'));
        return Schema::getColumnListing($form->tabla);
    }

    public function getTablas() {
        $all_tablas = array_map('reset', DB::select('SHOW TABLES'));
        return array_filter(array_map(function($n) { if(($n != 'migrations') && ($n != 'failed_jobs') && ($n != 'password_resets')) return $n; }, $all_tablas));
    }
}