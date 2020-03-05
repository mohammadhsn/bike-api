<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 */
class Officer extends Model
{
    protected $fillable = ['name'];

    protected $visible = ['id', 'name'];

    public function bike()
    {
        return $this->hasOne(Bike::class);
    }
}
