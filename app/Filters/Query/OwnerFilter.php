<?php


namespace App\Filters\Query;

use Illuminate\Database\Eloquent\Builder;

class OwnerFilter extends QueryFilter
{
    protected function filter(Builder $builder)
    {
        $builder->where('owner', 'like', "%{$this->request->get('owner')}%");
    }

    protected function satisfied()
    {
        return $this->request->has('owner');
    }
}
