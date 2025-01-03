<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{
    use HasFactory;

    protected $fillable = ['usuario_id', 'questionario_id', 'pontuacao'];

    public function usuarios()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function questionario()
    {
        return $this->belongsTo(Questionario::class);
    }
}