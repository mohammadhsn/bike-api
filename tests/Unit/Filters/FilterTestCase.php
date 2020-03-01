<?php


namespace Test\Unit\Filters;

use App\Filters\Query\QueryFilter;
use Illuminate\Http\Request;
use Test\Utility\TestCase;

abstract class FilterTestCase extends TestCase
{
    /**
     * @var Request
     */
    protected $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = $this->createMock(Request::class);
    }

    protected function addRequestMethod($method, $argument, $return): self
    {
        $this->request->expects($this->once())
            ->method($method)
            ->with($argument)
            ->willReturn($return);

        return $this;
    }

    abstract protected function getObject(): QueryFilter;
}
