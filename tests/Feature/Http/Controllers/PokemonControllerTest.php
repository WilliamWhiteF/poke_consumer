<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PokemonControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->post('/api/pokemon/magikarp');

        $response->assertCreated();
    }

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_not_implemented(): void
    {
        $response = $this->post('/api/pokemon/torterra');

        $response->assertStatus(501);
    }
}
