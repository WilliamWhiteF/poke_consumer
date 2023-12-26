<?php

namespace App\Domains\Pokemon\Actions;

use App\Domains\Pokemon\Dto\PokemonDto;
use App\Domains\Pokemon\Dto\SearchPokemonDto;
use Illuminate\Support\Facades\Http;

/**
 * Search for the pokemon on pokeapi
 * Prepares it on DTO, and send to process
 */
class SearchPokemonAction
{
    public function __construct(
        private ProcessPokemonAction $processPokemonAction
    ) { }

    public function execute(SearchPokemonDto $pokemonDto): bool
    {
        $request = Http::get('https://pokeapi.co/api/v2/pokemon/' . $pokemonDto->pokemon);
        if ($request->failed()) {
            throw new \Exception('Request Failed', 500);
        }

        $pokemon = $request->collect()
            ->only('name', 'species', 'weight', 'types');

        $types = implode(',', array_map(function ($type) {
            return $type['type']['name'];
        }, $pokemon->get('types')));

        $pokemon = $pokemon->replace([
            'types' => $types,
            'species' => $pokemon->get('species')['name'],
        ]);

        $pokemon = new PokemonDto(...$pokemon->toArray());
        return $this->processPokemonAction->execute($pokemon);
    }
}
