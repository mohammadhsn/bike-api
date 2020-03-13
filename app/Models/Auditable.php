<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Auditable
{
    public function audits(): MorphMany
    {
        return $this->morphMany(Audit::class, 'auditable');
    }
}
