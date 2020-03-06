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
        $this->bikes = factory(Bike::class, 10)->create(['color' => 'red']);
    }

    /** @test */
    public function it_lists_all_bikes()
    {
        $this->get('bikes')
            ->assertResponseOk();

        $this->seeJsonStructure(['data' => ['*' => [
            'id',
            'type',
            'color',
            'owner',
            'theft_at',
            'found',
            'licence_number',
            'description',
            'created_at',
            'updated_at',
        ]]]);
    }

    /** @test */
    public function it_applies_filters()
    {
        factory(Bike::class)->create(['color' => 'yellow']);
        $this->get('bikes?color=yellow');
        $this->assertCount(
            1,
            json_decode($this->response->content(), true)['data']
        );
    }

    /** @test */
    public function it_ignores_unauthorized_filters()
    {
        $this->get('bikes?id=1');
        $this->assertCount(
            10,
            json_decode($this->response->content(), true)['data']
        );
    }
}
