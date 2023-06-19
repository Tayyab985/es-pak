<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerQueries extends Model
{
    use HasFactory;

    protected $table = "customer_queries";
    protected $fillable = ['customer_id', 'current_state'];

    public function queryTests() : HasMany
    {
        return $this->HasMany(QueryTests::class, "customer_query_id", 'id');
    }

    public function customer() : BelongsTo
    {
        return $this->belongsTo(Customers::class, 'customer_id', 'id');
    }
}
