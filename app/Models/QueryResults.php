<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QueryResults extends Model
{
    use HasFactory;

    protected $table = "query_parameter_results";

    protected $fillable = ['concentration', 'remarks', 'lab_test_id', 'lab_test_parameter_id', 'customer_id',
     'customer_query_id', 'sample_image_path', 'sample_collected', 'operator_id'];

    
     public function customerQuery() : BelongsTo
     {
        return $this->belongsTo(CustomerQueries::class, 'customer_query_id', 'id');
     }

     public function operator() : BelongsTo
     {
        return $this->belongsTo(Operators::class, 'operator_id', 'id');
     }
}
