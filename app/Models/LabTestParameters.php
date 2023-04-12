<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LabTestParameters extends Model
{
    use HasFactory;

    protected $table = 'labtestparameters';
    protected $fillable = ['name', 'method', 'equipment_used', 'uncertanity', 'lab_test_id'];


    public function labTest() : BelongsTo
    {
        return $this->belongsTo(LabTests::class, "lab_test_id", 'id');
    }
}
