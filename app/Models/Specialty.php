<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    protected $fillable = ['name'];

    public function leads(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Lead::class);
    }

}
