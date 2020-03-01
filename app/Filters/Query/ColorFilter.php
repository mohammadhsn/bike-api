<?php


namespace App\Filters\Query;

use Illuminate\Database\Eloquent\Builder;

class ColorFilter extends QueryFilter
{
    protected function filter(Builder $builder)
    {
        $builder->where('color', $this->request->get('color'));
    }

    protected function satisfied()
    {
        return $this->request->has('color');
    }
}
