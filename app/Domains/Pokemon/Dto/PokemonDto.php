<?php

namespace App\Domains\Pokemon\Dto;

class PokemonDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $species,
        public readonly int $weight,
        public readonly string $types
    ) { }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'species' => $this->species,
            'weight' => $this->weight,
            'types' => $this->types,
        ];
    }
}
