<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customers extends Model
{
    use HasFactory;

    protected $fillable = ['company_name', 'company_address', 'company_phone', 'company_email', 'password', 'generated_id'];

    public function locations() : HasMany
    {
        return $this->hasMany(Locations::class, 'customer_id', 'id');
    }

    public function contactPersons() : HasMany
    {
        return $this->hasMany(ContactPerson::class, "customer_id", "id");
    }
}
