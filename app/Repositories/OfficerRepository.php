<?php


namespace App\Repositories;

use App\Models\Officer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function create(array $data): Model
    {
        DB::beginTransaction();


        try {
            $officer = parent::create($data);
            $bike = $this->getBikeRepository()->findPending();
            if ($bike) {
                $bike->update(['officer_id' => $officer->id]);
                $officer->load('bike');
            }
            DB::commit();

            return $officer;
        } catch (\Exception $e) {
        }
    }


    protected function getBikeRepository(): BikeRepository
    {
        return app(BikeRepository::class);
    }
}
