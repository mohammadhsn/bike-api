<?php


namespace Test\Integration;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Test\TestCase;

class OfficerTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_creates_new_officer()
    {
        $this->json('POST', 'officers', ['name' => 'Ali Kalan']);

        $this->assertEquals($this->response->status(), 201);

        $this->seeJson([
            'id' => 1,
            'name' => 'Ali Kalan'
        ]);
    }

    /** @test */
    public function it_requires_name()
    {
        $this->json('POST', 'officers')
            ->assertResponseStatus(422);
    }
}
