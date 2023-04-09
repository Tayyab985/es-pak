<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customers extends Model
{
    use HasFactory;

    protected $fillable = ['company_name', 'company_address', 'company_phone', 'company_email', 'generated_id'];
    protected $hidden = ['password'];

    public function location() : HasMany
    {
        return $this->hasMany(Locations::class, 'customer_id', 'id');
    }
}
