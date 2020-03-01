<?php


namespace Test\Unit\Filters;

use App\Filters\Query\QueryFilter;
use App\Filters\Query\TheftDateFilter;
use App\Models\Bike;

class TheftDateFilterTest extends FilterTestCase
{
    protected function getObject(): QueryFilter
    {
        return new TheftDateFilter($this->request);
    }

    /** @test */
    public function it_satisfy_correctly()
    {
        $filter = $this->addRequestMethod('has', 'theft_at', false)
            ->getObject();

        $filter->apply($builder = Bike::query());

        $this->assertCount(0, $builder->getQuery()->wheres);
    }

    /** @test */
    public function it_applies_on_correct_column()
    {
        $filter = $this->addRequestMethod('has', 'theft_at', true)
            ->getObject();

        $filter->apply($builder = Bike::query());

        $this->assertEquals($builder->getQuery()->wheres[0]['column'], 'theft_at');
    }
}
