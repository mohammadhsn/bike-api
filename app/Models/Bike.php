<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $id
 * @property $licence_number
 * @property $type
 * @property $owner
 * @property $color
 * @property $description
 * @property $theft_at
 * @property $officer_id
 * @property $found
 * @property Officer|null $officer
 */
class Bike extends Model
{
    protected $fillable = [
        'licence_number',
        'type',
        'owner',
        'color',
        'description',
        'theft_at',
        'officer_id',
        'found',
    ];

    protected $casts = [
        'found' => 'bool',
        'licence_number' => 'int',
    ];

    protected $visible = [
        'id',
        'licence_number',
        'type',
        'owner',
        'color',
        'description',
        'theft_at',
        'found',
        'officer',
    ];

    public function officer()
    {
        return $this->belongsTo(Officer::class);
    }
}
