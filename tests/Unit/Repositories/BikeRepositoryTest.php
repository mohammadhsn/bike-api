<?php


namespace Test\Unit\Repositories;

use App\Models\Bike;
use App\Models\Officer;
use App\Repositories\BikeRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
    public function it_doesnt_find_solved_as_pending()
    {
        factory(Bike::class)->create(['officer_id' => null, 'found' => true]);
        $this->assertNull($this->repository->findPending());
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

    /** @test */
    public function it_throws_exception_for_invalid_id()
    {
        $this->expectException(ModelNotFoundException::class);
        $this->repository->resolve(10);
    }

    /** @test */
    public function it_throws_exception_for_bike_without_officer()
    {
        $bike = factory(Bike::class)->create(['officer_id' => null]);
        $this->expectException(ModelNotFoundException::class);
        $this->repository->resolve($bike->id);
    }

    /** @test */
    public function it_throws_exception_for_found_cases()
    {
        $bike = factory(Bike::class)->create(['found' => true]);
        $this->expectException(ModelNotFoundException::class);
        $this->repository->resolve($bike->id);
    }

    /** @test */
    public function it_updates_bike_columns()
    {
        $bike = factory(Bike::class)->create();
        $this->repository->resolve($bike->id);

        $bike->refresh();

        $this->assertNull($bike->officer_id);
        $this->assertTrue($bike->found);
    }

    /** @test */
    public function it_assigns_officer_to_an_other_case()
    {
        $bike = factory(Bike::class)->create();
        $bike2 = factory(Bike::class)->create();

        $out = $this->repository->resolve($bike->id);

        $this->assertInstanceOf(Officer::class, $bike2->refresh()->officer);
        $this->assertTrue($out);
    }
}
