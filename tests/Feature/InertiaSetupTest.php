<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InertiaSetupTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_inertia_route_works()
    {
        $response = $this->get('/inertia-test');

        $response->assertStatus(200);
        $response->assertInertia(fn($page) => $page->component('Welcome'));
    }
}
