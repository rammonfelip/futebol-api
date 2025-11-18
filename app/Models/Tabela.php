<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tabela extends Model
{
    protected $table = 'campeonato_tabela';
    protected $fillable = [
        'campeonato_id',
        'time_id',
        'time_nome',
        'time_sigla',
        'time_logo',
        'posicao',
        'pontos',
        'jogos',
        'vitorias',
        'empates',
        'derrotas',
        'aproveitamento',
    ];
    public $incrementing = false;
}
