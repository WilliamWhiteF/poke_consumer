<?php

namespace App\Domains\Pokemon\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pokemons extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'species',
        'types',
        'weight',
        'name'
    ];
}
