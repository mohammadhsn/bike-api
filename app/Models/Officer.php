<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property Bike|null $bike
 */
class Officer extends Model
{
    protected $fillable = ['name'];

    public function bike()
    {
        return $this->hasOne(Bike::class);
    }
}
