<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LabTests extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    protected $table = 'labtests';

    public function labTestParameters() : HasMany
    {
        return $this->hasMany(LabTestParameters::class, "lab_test_id", 'id');
    }

    public function queryTests() : HasMany
    {
        return $this->HasMany(QueryTests::class, "lab_test_id", 'id');
    }
}
