<?php

namespace App\Models;
use App\Scopes\VisibleScope;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;

    protected $table = 'perfiles';

    public function user()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Con esto se protege en todas las referencias
     * al modelo que no aparezcan los que no son visibles true
     */

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new VisibleScope);
    }
}
