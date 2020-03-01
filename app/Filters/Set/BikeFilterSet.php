<?php


namespace App\Filters\Set;

use App\Filters\Query\ColorFilter;
use App\Filters\Query\OwnerFilter;
use App\Filters\Query\TheftDateFilter;
use App\Filters\Query\TypeFilter;
use App\Models\Bike;

class BikeFilterSet extends FilterSet
{
    protected $filterClasses = [
        OwnerFilter::class,
        ColorFilter::class,
        TypeFilter::class,
        TheftDateFilter::class,
    ];

    protected function getModel()
    {
        return Bike::class;
    }
}
