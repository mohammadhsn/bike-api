<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];

    public function officer()
    {
        return $this->belongsTo(Officer::class);
    }
}
