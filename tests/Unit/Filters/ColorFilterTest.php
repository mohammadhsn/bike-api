<?php


namespace Test\Unit\Filters;

use App\Filters\Query\ColorFilter;
use App\Filters\Query\QueryFilter;
use App\Models\Bike;

class ColorFilterTest extends FilterTestCase
{
    protected function getObject(): QueryFilter
    {
        return new ColorFilter($this->request);
    }

    /** @test */
    public function it_satisfy_correctly()
    {
        $filter = $this->addRequestMethod('has', 'color', false)
            ->getObject();

        $filter->apply($builder = Bike::query());

        $this->assertCount(0, $builder->getQuery()->wheres);
    }

    /** @test */
    public function it_applies_on_correct_column()
    {
        $filter = $this->addRequestMethod('has', 'color', true)
            ->getObject();

        $filter->apply($builder = Bike::query());

        $this->assertEquals($builder->getQuery()->wheres[0]['column'], 'color');
    }
}
