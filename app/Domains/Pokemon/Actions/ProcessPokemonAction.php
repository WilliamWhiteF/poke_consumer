<?php

namespace App\Domains\Pokemon\Actions;

use App\Domains\Pokemon\Dto\PokemonDto;
use App\Domains\Pokemon\Enum\ProcessablePokemonTypes;
use App\Domains\Pokemon\Exceptions\InvalidPokemonException;
use App\Domains\Pokemon\Models\Pokemons;
use App\Domains\Pokemon\Jobs\ProcessFirePokemonJob;

/**
 * Process fire and water Pokemons
 * This could be separated using strategy or CoR, but there are only two.
 * So, for simplicity, it was kept together
 */
class ProcessPokemonAction
{
    private const MAXIMUM_WEIGHT = 200;
    public function __construct() { }

    public function execute(PokemonDto $pokemon)
    {
        if (
            $pokemon->types === ProcessablePokemonTypes::Water->value
            && $pokemon->weight < self::MAXIMUM_WEIGHT
        ) {
            $pokemon = Pokemons::create($pokemon->toArray());
            if (!$pokemon->save()) {
                throw new \Exception('Database Error', 500);
            }

            return true;
        }

        if (
            $pokemon->types === ProcessablePokemonTypes::Fire->value
            && $pokemon->weight < self::MAXIMUM_WEIGHT
        ) {
            dispatch(new ProcessFirePokemonJob($pokemon));
            return true;
        }

        throw new InvalidPokemonException('Invalid Pokemon', 501);
    }
}
