<?php


namespace App\Repositories;


use App\Models\Officer;

class OfficerRepository extends BaseRepository
{
    public function __construct(Officer $model)
    {
        parent::__construct($model);
    }

    /**
     * @return Officer|null
     */
    public function findIdle()
    {
        return Officer::doesntHave('bike')->first();
    }
}
