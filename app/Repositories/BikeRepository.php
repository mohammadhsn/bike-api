<?php


namespace App\Repositories;

use App\Filters\Set\BikeFilterSet;
use App\Models\Bike;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
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
        return $this->getModel()
            ->where('found', false)
            ->whereNull('officer_id')
            ->first();
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
        } catch (Exception $e) {
            DB::rollBack();

            return false;
        }
    }

    public function filter(Request $request)
    {
        return $this->filterSet->setRequest($request)
            ->getBuilder()
            ->latest()
            ->paginate($this->peerPage);
    }

    public function resolve($id): bool
    {
        $bike = $this->getModel()
            ->where('id', $id)
            ->whereNotNull('officer_id')
            ->where('found', false)
            ->first();

        if (!$bike) {
            throw new ModelNotFoundException();
        }

        DB::beginTransaction();

        $officer = $bike->officer_id;

        try {
            $bike->update(['found' => true, 'officer_id' => null]);

            if ($pending = $this->findPending()) {
                $pending->update(['officer_id' => $officer]);
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}
