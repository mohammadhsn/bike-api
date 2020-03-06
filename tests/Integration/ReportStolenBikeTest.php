<?php


namespace Test\Integration;

use App\Models\Bike;
use App\Models\Officer;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Test\Utility\TestCase;

class ReportStolenBikeTest extends TestCase
{
    use DatabaseMigrations;

    protected $payload = [
        'licence_number' => '1111111111',
        'owner' => 'Kalan',
        'color' => 'red',
        'type' => 'bmx',
        'theft_at' => '2020-02-10',
        'description' => 'Some detail about this case',
    ];

    /** @test */
    public function it_stores_new_cases()
    {
        $this->json('POST', 'bikes', $this->payload);

        $this->assertResponseStatus(201);
        $this->seeJsonStructure(['id'])->seeJson($this->payload);
    }

    /** @test */
    public function it_assigns_an_officer_to_bike()
    {
        $officer = factory(Officer::class)->create();
        $this->json('POST', 'bikes', $this->payload);

        $this->seeJson(['officer' => ['id' => $officer->id, 'name' => $officer->name]]);
    }

    /** @test */
    public function it_validates_payload()
    {
        foreach ($this->payload as $key => $value) {
            $payload = $this->payload;
            unset($payload[$key]);
            $this->json('POST', 'bikes', $payload)
                ->assertResponseStatus(422);
        }
    }

    /** @test */
    public function it_doesnt_store_duplicates()
    {
        $this->json('POST', 'bikes', $this->payload);

        $this->json('POST', 'bikes', $this->payload);

        $this->assertResponseStatus(422);
    }

    /** @test */
    public function mark_as_found()
    {
        $officer = factory(Officer::class)->create();
        $bike = factory(Bike::class)->create(['officer_id' => $officer->id]);

        $this->json('PATCH', "/bikes/{$bike->id}", ['found' => true]);

        $this->assertResponseStatus(204);
    }

    /** @test */
    public function solve_a_non_existing_bike()
    {
        $this->json('PATCH', 'bikes/10')
            ->assertResponseStatus(404);
    }
}
