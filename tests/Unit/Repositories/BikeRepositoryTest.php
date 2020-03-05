<?php


namespace Test\Unit\Repositories;

use App\Models\Bike;
use App\Models\Officer;
use App\Repositories\BikeRepository;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Test\Utility\TestCase;

class BikeRepositoryTest extends TestCase
{
    use DatabaseMigrations;
    protected $repository;
    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->app->make(BikeRepository::class);
    }

    /** @test */
    public function it_finds_pending_ones()
    {
        $bike = factory(Bike::class)->create(['officer_id' => null]);
        $this->assertTrue($bike->is($this->repository->findPending()));
    }

    /** @test */
    public function theft_stores_the_bike()
    {
        $bike = factory(Bike::class)->make(['officer_id' => null]);
        $this->repository->theft($bike->toArray());

        $this->assertEquals(Bike::count(), 1);
    }

    /** @test */
    public function theft_assigns_to_officer()
    {
        $bike = factory(Bike::class)->make(['officer_id' => null]);
        $officer = factory(Officer::class)->create();
        $this->repository->theft($bike->toArray());
        $this->assertInstanceOf(Bike::class, $officer->refresh()->bike);
    }
}
