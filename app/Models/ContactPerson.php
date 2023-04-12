<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContactPerson extends Model
{
    use HasFactory;

    protected $table = "contactpersons";
    protected $fillable = ['name', 'phone_number', 'customer_id'];

    public function customers() : BelongsTo
    {
        return $this->HasMany(Customers::class, 'id', 'customer_id');
    }
}
