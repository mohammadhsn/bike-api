<?php


namespace Test\Integration;


use App\Models\Bike;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Test\Utility\TestCase;

class StolenBikesListTest extends TestCase
{
    use DatabaseMigrations;

    private $bikes;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bikes = factory(Bike::class, 10)->create();
    }

    /** @test */
    public function it_lists_all_bikes()
    {
        $this->get('bikes')
            ->assertResponseOk();

        $this->seeJsonStructure(["data" => ["*" => [
            "id", "type", "color", "owner", "theft_at", "licence_number", "description", "created_at", "updated_at"
        ]]]);

    }
}
