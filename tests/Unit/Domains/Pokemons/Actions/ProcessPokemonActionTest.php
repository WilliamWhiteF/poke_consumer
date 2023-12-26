<?php

namespace Tests\Unit\Domains\Pokemon\Actions;

use App\Domains\Pokemon\Actions\ProcessPokemonAction;
use App\Domains\Pokemon\Dto\PokemonDto;
use App\Domains\Pokemon\Exceptions\InvalidPokemonException;
use App\Domains\Pokemon\Jobs\ProcessFirePokemonJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use PHPUnit\Framework\Attributes\DataProvider;

class ProcessPokemonActionTest extends \Tests\TestCase
{
    use RefreshDatabase;

    private ProcessPokemonAction $action;

    public function setUp(): void
    {
        parent::setUp();
        $this->action = app(ProcessPokemonAction::class);
    }

    public static function invalidPokemonProvider()
    {
        return [
            [new PokemonDto('wailord', 'wailord', 3980, 'water')],
            [new PokemonDto('charizard', 'charizard', 500, 'fire')],
            [new PokemonDto('torterra', 'torterra', 3100, 'grass, ground')],
        ];
    }

    public function test_pokemon_water_is_saved(): void
    {
        $pokemonDto = new PokemonDto('magikarp', 'magikarp', 100, 'water');

        $this->assertTrue($this->action->execute($pokemonDto));
        $this->assertDatabaseCount('pokemons', 1);
    }

    #[DataProvider('invalidPokemonProvider')]
    public function test_pokemon_is_invalid(PokemonDto $pokemonDto): void
    {
        $this->expectException(InvalidPokemonException::class);
        $this->action->execute($pokemonDto);
    }

    public function test_pokemon_fire_is_sent_to_queue(): void
    {
        Bus::fake();

        $pokemonDto = new PokemonDto('charmander', 'charmander', 85, 'fire');
        $this->assertTrue($this->action->execute($pokemonDto));

        Bus::assertDispatched(ProcessFirePokemonJob::class);
    }
}
