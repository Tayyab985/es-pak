<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Units extends Model
{
    use HasFactory;

    protected $table = "units";
    protected $fillable = ['name', 'lab_test_parameter_id'];

    public function labTestParameters() : BelongsTo
    {
        return $this->belongsTo(LabTestParameters::class, 'lab_test_parameter_id', 'id');
    }
}
