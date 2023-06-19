<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OperatorsWorked extends Model
{
    use HasFactory;

    protected $table = 'operatorsWorked';

    protected $fillable = ['operator_id', 'role', 'customer_query_id'];

    public function customers() : BelongsToMany
    {
        return $this->BelongsToMany(CustomerQueries::class, 'customer_query_id', 'id');
    }
}
