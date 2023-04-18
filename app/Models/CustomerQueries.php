<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomerQueries extends Model
{
    use HasFactory;

    protected $table = "customer_queries";
    protected $fillable = ['customer_id', 'lab_test_ids', 'current_state', 'operators_id'];

    public function queryParams() : HasMany
    {
        return $this->HasMany(QueryParameters::class, "customer_query_id", 'id');
    }
}
