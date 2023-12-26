<?php

namespace App\Domains\Pokemon\Dto;

class SearchPokemonDto
{
    public function __construct(
        public readonly string $pokemon
    ) { }
}
