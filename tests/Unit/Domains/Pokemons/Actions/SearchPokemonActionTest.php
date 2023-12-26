<?php

namespace Tests\Unit\Domains\Pokemon\Actions;

use App\Domains\Pokemon\Actions\ProcessPokemonAction;
use App\Domains\Pokemon\Actions\SearchPokemonAction;
use App\Domains\Pokemon\Dto\SearchPokemonDto;
use Illuminate\Support\Facades\Http;
use Mockery\MockInterface;
use Tests\TestCase;

class SearchPokemonActionTest extends TestCase
{
    private SearchPokemonDto $searchPokemonDto;

    public function setUp(): void
    {
        parent::setUp();
        $this->searchPokemonDto = new SearchPokemonDto('charmander');
    }

    public function test_pokemon_should_be_searched(): void
    {
        // mock Http
        Http::fake([
            'pokeapi.co/*' => Http::response([
                'name' => 'charmander',
                'species' => [
                    'name' => 'charmander',
                    'url' => '',
                ],
                'weight' => 85,
                'types' => [
                    [
                        'slot' => 1,
                        'type' => [
                            'name' => 'fire',
                            'url' => ''
                        ]
                    ]
                ],
            ], 200)
        ]);

        $mock = $this->mock(
            ProcessPokemonAction::class,
            fn (MockInterface $mock) => $mock->shouldReceive('execute')->once()->andReturn(true)
        );

        $action = app(SearchPokemonAction::class);
        $action->execute($this->searchPokemonDto);

        Http::assertSentCount(1);
    }
}
