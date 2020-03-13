<?php


namespace Test\Unit\Repositories;

use App\Models\Audit;
use App\Models\Bike;
use App\Repositories\AuditRepository;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Test\Utility\TestCase;

class AuditRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    /** @var AuditRepository */
    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->app->make(AuditRepository::class);
    }

    /** @test */
    public function it_persists_for_auditable_models()
    {
        $bike = factory(Bike::class)->create(['officer_id' => null]);

        $audit = $this->repository->createFor($bike, ['foo' => 'bar']);

        $this->assertInstanceOf(Audit::class, $audit);

        $this->assertEquals($audit->id, Audit::first()->id);
    }
}
