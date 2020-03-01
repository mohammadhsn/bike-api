<?php


namespace App\Filters\Query;

use Illuminate\Database\Eloquent\Builder;

class TheftDateFilter extends QueryFilter
{
    protected function filter(Builder $builder)
    {
        $builder->where('theft_at', $this->request->get('theft_at'));
    }

    protected function satisfied()
    {
        return $this->request->has('theft_at');
    }
}
