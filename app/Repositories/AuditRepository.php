<?php


namespace App\Repositories;

use App\Models\Audit;
use App\Models\AuditableInterface;

class AuditRepository extends BaseRepository
{
    public function __construct(Audit $model)
    {
        parent::__construct($model);
    }

    public function createFor(AuditableInterface $model, array $payload)
    {
        return $model->audits()
            ->create(compact('payload'));
    }
}
