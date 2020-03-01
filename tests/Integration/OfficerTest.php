<?php


namespace Test\Integration;

use App\Models\Officer;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Test\Utility\TestCase;

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
            'name' => 'Ali Kalan',
        ]);
    }

    /** @test */
    public function it_requires_name_to_create()
    {
        $this->json('POST', 'officers')
            ->assertResponseStatus(422);
    }

    /** @test */
    public function it_removes_existing_officer()
    {
        $officer = factory(Officer::class)->create();

        $this->json('DELETE', "officers/{$officer->id}")
            ->assertResponseStatus(204);

        $this->json('DELETE', "officers/{$officer->id}")
            ->assertResponseStatus(404);
    }
}
