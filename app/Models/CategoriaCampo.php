<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaCampo extends Model
{
    use HasFactory;

    public function campo()
    {
        return $this->hasMany(Campo::class);
    }
}
