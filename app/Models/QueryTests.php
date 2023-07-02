<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QueryTests extends Model
{
    use HasFactory;

    protected $fillable = ['lab_test_id', 'lab_test_parameter_ids', 'customer_query_id'];


    public function labTest() : BelongsTo
    {
        return $this->belongsTo(LabTests::class, 'lab_test_id', 'id');
    }

    public function customerQuery() : BelongsTo
    {
        return $this->belongsTo(CustomerQueries::class, "id", "customer_query_id");
    }


}
