<?php


namespace App\Filters\Query;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter
{
    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        if ($this->satisfied()) {
            $this->filter($builder);
        }
    }

    abstract protected function filter(Builder $builder);

    protected function satisfied()
    {
        return true;
    }
}
