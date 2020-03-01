<?php


namespace Test\Unit\Filters;

use App\Filters\Query\OwnerFilter;
use App\Filters\Query\QueryFilter;
use App\Models\Bike;

class OwnerFilterTest extends FilterTestCase
{
    protected function getObject(): QueryFilter
    {
        return new OwnerFilter($this->request);
    }

    /** @test */
    public function it_applies_filter_stuff()
    {
        $filter = $this->addRequestMethod('has', 'owner', true)
            ->getObject();

        $filter->apply($builder = Bike::query());

        $this->assertCount(1, $builder->getQuery()->wheres);
        $this->assertEquals($builder->getQuery()->wheres[0]['operator'], 'like');
    }

    /** @test */
    public function it_applies_on_correct_column()
    {
        $filter = $this->addRequestMethod('has', 'owner', true)
            ->getObject();

        $filter->apply($builder = Bike::query());

        $this->assertEquals($builder->getQuery()->wheres[0]['column'], 'owner');
    }

    /** @test */
    public function it_satisfy_correctly()
    {
        $filter = $this->addRequestMethod('has', 'owner', false)
            ->getObject();

        $filter->apply($builder = Bike::query());

        $this->assertCount(0, $builder->getQuery()->wheres);
    }

    /** @test */
    public function it_applies_like_operator()
    {
        $filter = $this->addRequestMethod('has', 'owner', true)
            ->getObject();

        $filter->apply($builder = Bike::query());

        $this->assertEquals($builder->getQuery()->wheres[0]['operator'], 'like');
    }
}
