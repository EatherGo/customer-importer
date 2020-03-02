<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'telephone', 'valid', 'errors', 'dirtiness'];

    protected $casts = [
        'dirtiness' => 'integer'
    ];

    /**
     * Get only valid customers
     *
     * @param $query
     * @return mixed
     */
    public function scopeValid($query)
    {
        return $query->where('valid', 1);
    }

    /**
     * Get only invalid customers
     *
     * @param $query
     * @return mixed
     */
    public function scopeInvalid($query)
    {
        return $query->where('valid', 0);
    }
}
