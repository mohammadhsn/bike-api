<?php


namespace Test\Unit\Repositories;


use App\Models\Officer;
use App\Repositories\OfficerRepository;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Test\Utility\TestCase;

class OfficerRepositoryTest extends TestCase
{

    use DatabaseMigrations;

    /** @var OfficerRepository */
    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->app->make(OfficerRepository::class);
    }

    /** @test */
    public function it_finds_idle()
    {

        $this->assertNull($this->repository->findIdle());

        $officer = factory(Officer::class)->create();

        $this->assertInstanceOf(Officer::class, $this->repository->findIdle());
        $this->assertEquals($officer->id, $this->repository->findIdle()->id);

    }
}
