<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questionario extends Model
{
    protected $fillable = ['titulo'];

    public function perguntas()
    {
        return $this->hasMany(Pergunta::class);
    }
}