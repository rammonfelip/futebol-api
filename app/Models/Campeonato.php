<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campeonato extends Model
{
    protected $table = 'campeonato';
    protected $fillable = [
        'external_id', 'nome', 'nome_popular', 'slug', 'temporada', 'image_url'
    ];
}
