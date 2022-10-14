<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCampo extends Model
{
    use HasFactory;

    public function campo()
    {
        return $this->hasMany(Campo::class);
    }
}
