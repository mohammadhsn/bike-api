<?php


namespace App\Filters\Query;

use Illuminate\Database\Eloquent\Builder;

class TypeFilter extends QueryFilter
{
    protected function filter(Builder $builder)
    {
        $builder->where('type', $this->request->get('type'));
    }

    protected function satisfied()
    {
        return $this->request->has('type');
    }
}
