<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Operators extends Model
{
    use HasFactory;

     protected $fillable = ['username', 'email', 'password', 'phone_number', 'role', 'department_id', 'password'];

   public function department() : BelongsTo
   {
        return $this->belongsTo(Departments::class, 'department_id', 'id');
   }

}
