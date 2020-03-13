<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property @id
 * @property Model $auditable
 * @property array $payload
 */
class Audit extends Model
{
    const UPDATED_AT = null;

    protected $casts = [
        'payload' => 'array',
    ];

    protected $fillable = ['payload'];

    public function auditable()
    {
        return $this->morphTo();
    }
}
