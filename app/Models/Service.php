<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['name', 'code'];

    public function queues()
    {
        return $this->hasMany(Queue::class);
    }
}
