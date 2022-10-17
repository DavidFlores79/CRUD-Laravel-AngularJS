<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campo extends Model
{
    use HasFactory;

    public function tipo_formulario()
    {
        return $this->belongsTo(TipoFormulario::class, "tipo_formulario_id");
    }

    public function tipo_campo()
    {
        return $this->belongsTo(TipoCampo::class, "tipo_campo_id");
    }
}
