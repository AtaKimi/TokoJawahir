<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    protected $seeder = TestSeeder::class;

    protected $seed = true;

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        // because got redirected to another page
        $response->assertStatus(302);
    }
}
