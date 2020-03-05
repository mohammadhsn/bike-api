<?php


namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var int
     */
    protected $peerPage = 20;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    protected function getModel()
    {
        return $this->model;
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): int
    {
        return call_user_func([$this->getModel(), 'where'], 'id', $id)
            ->update($data);
    }

    public function delete(int ...$ids): int
    {
        return call_user_func([$this->getModel(), 'whereIn'], 'id', $ids)->delete();
    }

    public function paginate($peerPage = null)
    {
        return call_user_func([$this->getModel(), 'latest'])
            ->latest()
            ->paginate($peerPage ?: $this->peerPage);
    }
}
