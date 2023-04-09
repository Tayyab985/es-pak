<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departments extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function operator() : HasMany
    {
        return $this->hasMany(Operators::class, 'department_id', 'id');
    }
}
