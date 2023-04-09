<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Locations extends Model
{
    use HasFactory; 
    protected $fillable = ['street1', 'street22', 'city', 'region', 'customer_id'];

    public function customer() : BelongsTo
    {
        return $this->belongsTo(Customers::class, 'customer_id', 'id');
    }
}
