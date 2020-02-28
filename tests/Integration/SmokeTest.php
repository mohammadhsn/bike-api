<?php

namespace Test\Integration;

use Test\TestCase;

class SmokeTest extends TestCase
{
    /** @test */
    public function it_works()
    {
        $this->json('GET', '/')
            ->assertResponseOk();
    }

    /** @test */
    public function it_returns_app_version()
    {
        $this->json('GET', '/')
            ->seeJson(['version' => $this->app->version()]);
    }
}
