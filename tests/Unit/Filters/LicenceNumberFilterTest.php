<?php


namespace Test\Unit\Filters;

use App\Filters\Query\LicenceNumberFilter;
use App\Filters\Query\QueryFilter;
use App\Models\Bike;

class LicenceNumberFilterTest extends FilterTestCase
{
    protected function getObject(): QueryFilter
    {
        return new LicenceNumberFilter($this->request);
    }

    /** @test */
    public function it_satisfy_correctly()
    {
        $filter = $this->addRequestMethod('has', 'licence_number', false)
            ->getObject();

        $filter->apply($builder = Bike::query());

        $this->assertCount(0, $builder->getQuery()->wheres);
    }

    /** @test */
    public function it_applies_on_correct_column()
    {
        $filter = $this->addRequestMethod('has', 'licence_number', true)
            ->getObject();

        $filter->apply($builder = Bike::query());

        $this->assertEquals($builder->getQuery()->wheres[0]['column'], 'licence_number');
    }
}
