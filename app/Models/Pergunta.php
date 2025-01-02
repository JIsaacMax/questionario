<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pergunta extends Model
{
    protected $fillable = ['texto', 'questionario_id'];

    public function respostas()
    {
        return $this->hasMany(Resposta::class);
    }

    public function questionario()
    {
        return $this->belongsTo(Questionario::class);
    }
}