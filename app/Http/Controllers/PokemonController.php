<?php

namespace App\Http\Controllers;

use App\Domains\Pokemon\Actions\SearchPokemonAction;
use App\Domains\Pokemon\Dto\SearchPokemonDto;
use App\Domains\Pokemon\Exceptions\InvalidPokemonException;
use App\Domains\Pokemon\Models\Pokemons;
use Illuminate\Support\Facades\Log;

class PokemonController extends Controller
{
    /**
     * apenas para teste, deveria passar para outro lugar, vou remover
     */
    public function index()
    {
        return Pokemons::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SearchPokemonAction $action, string $pokemon)
    {
        $pokemonDto = new SearchPokemonDto(strtolower($pokemon));

        try {
            $action->execute($pokemonDto);

            return response('', 201);
        } catch (InvalidPokemonException $e) {
            Log::error(
                "[POKEMON EXCEPTION] {$e->getFile()}:{$e->getLine()} - {$e->getMessage()} \n {$e->getTraceAsString()}"
            );

            return response($e->getMessage(), $e->getCode());
        } catch (\Exception $e) {
            Log::error("[EXCEPTION] {$e->getFile()}:{$e->getLine()} - {$e->getMessage()} \n {$e->getTraceAsString()}");

            return response('Serviço Indisponivel', 500);
        }
    }
}
