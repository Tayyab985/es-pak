<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LabTestParameterLimit extends Model
{
    use HasFactory;

    protected $table = 'lab_test_paramter_limits';
    protected $fillable = ['min_value', 'max_value', 'limit_type', 'lab_test_parameter_id'];

    public function labTestParameter() : BelongsTo
    {
        return $this->belongsTo(LabTestParameters::class, 'lab_test_parameter_id', 'id');
    }
}
