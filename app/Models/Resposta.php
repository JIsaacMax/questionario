<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resposta extends Model
{
    protected $fillable = ['texto', 'correta', 'pergunta_id'];

    public function pergunta()
    {
        return $this->belongsTo(Pergunta::class);
    }
}