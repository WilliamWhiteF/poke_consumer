<?php

namespace App\Domains\Pokemon\Jobs;

use App\Domains\Pokemon\Dto\PokemonDto;
use App\Domains\Pokemon\Models\Pokemons;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessFirePokemonJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private PokemonDto $pokemonDto
    ) { }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $pokemon = Pokemons::create($this->pokemonDto->toArray());
        if (!$pokemon->save()) {
            Log::error("[ERROR] pokemon failed {serialize($this->pokemonDto)}");
            return;
        }

        Log::info('[SUCCESS] POKEMON SAVED');
    }
}
