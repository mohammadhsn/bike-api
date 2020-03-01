<?php


namespace App\Filters\Set;

use App\Filters\Query\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class FilterSet
{
    /**
     * @var QueryFilter []
     */
    protected $filters;
    /**
     * @var array
     */
    protected $filterClasses = [];
    /**
     * @var Request
     */
    protected $request;

    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }

    protected function getFilters()
    {
        foreach ($this->filterClasses as $class) {
            if (is_subclass_of($class, QueryFilter::class)) {
                $this->addFilter(new $class($this->request));
            }
        }

        return $this->filters;
    }

    public function addFilter(QueryFilter $filter)
    {
        $this->filters [] = $filter;

        return $this;
    }

    abstract protected function getModel();

    protected function getBasicBuilder(): Builder
    {
        return call_user_func([$this->getModel(), 'query']);
    }

    public function getBuilder(): Builder
    {
        $builder = $this->getBasicBuilder();

        foreach ($this->getFilters() as $filter) {
            $filter->apply($builder);
        }

        return $builder;
    }
}
