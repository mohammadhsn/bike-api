<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface AuditableInterface
{
    public function audits(): MorphMany;
}
