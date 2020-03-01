<?php


namespace App\Filters\Query;

use Illuminate\Database\Eloquent\Builder;

class LicenceNumberFilter extends QueryFilter
{
    protected function filter(Builder $builder)
    {
        $builder->where('licence_number', $this->request->get('licence_number'));
    }

    protected function satisfied()
    {
        return $this->request->has('licence_number');
    }
}
