<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LabTestParameters extends Model
{
    use HasFactory;

    protected $table = 'labtestparameters';
    protected $fillable = ['name', 'method', 'equipment', 'uncertanity', 'units', 'lab_test_id'];


    public function labTest() : BelongsTo
    {
        return $this->belongsTo(LabTests::class, "lab_test_id", 'id');
    }

    public function limits() : HasMany
    {
        return $this->hasMany(LabTestParameterLimit::class, 'lab_test_parameter_id', 'id');
    }
}
