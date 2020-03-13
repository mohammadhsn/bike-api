<?php


namespace Test\Integration;

use App\Models\Bike;
use App\Models\Officer;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Test\Utility\TestCase;

class ShowSpecificBikeTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var Bike
     */
    protected $bike;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bike = factory(Bike::class)
            ->create(['officer_id' => null])
            ->refresh();
    }

    /** @test */
    public function it_shows_specific_bike()
    {
        $this->json('GET', "bikes/{$this->bike->id}");
        $this->assertResponseOk();
//        $this->seeJsonEquals([
//            'id' => $this->bike->id,
//            'licence_number' => $this->bike->licence_number,
//            'type' => $this->bike->type,
//            'theft_at' => $this->bike->theft_at,
//            'color' => $this->bike->color,
//            'description' => $this->bike->description,
//            'owner' => $this->bike->owner,
//            'found' => $this->bike->found
//        ]);
        $this->seeJsonEquals(array_merge($this->bike->toArray(), ['officer' => null]));
    }

    /** @test */
    public function it_contains_officer_for_in_progress_ones()
    {
        $officer = factory(Officer::class)->create();
        $this->bike->update(['officer_id' => $officer->id]);
        $this->json('GET', "bikes/{$this->bike->id}");
        $this->seeJsonEquals(array_merge($this->bike->toArray(), ['officer' => $officer->toArray()]));
    }

    /** @test */
    public function it_show_404_for_non_existing_ones()
    {
        $this->json('GET', 'bikes/2')->assertResponseStatus(404);
    }
}
