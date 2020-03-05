<?php


namespace App\Repositories;

use App\Filters\Set\BikeFilterSet;
use App\Models\Bike;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BikeRepository extends BaseRepository
{
    /**
     * @var BikeFilterSet
     */
    private $filterSet;
    /**
     * @var OfficerRepository
     */
    private $officerRepository;

    public function __construct(Bike $model, BikeFilterSet $filterSet, OfficerRepository $officerRepository)
    {
        parent::__construct($model);
        $this->filterSet = $filterSet;
        $this->officerRepository = $officerRepository;
    }

    public function findPending()
    {
        return $this->getModel()->whereNull('officer_id')->first();
    }

    /**
     * @param array $data
     *
     * @return bool|Bike|Model
     */
    public function theft(array $data)
    {
        DB::beginTransaction();

        try {
            $officer = $this->officerRepository->findIdle();
            if ($officer) {
                $data['officer_id'] = $officer->id;
            }
            $bike = $this->create($data);
            $bike->load('officer');
            DB::commit();

            return $bike;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}
