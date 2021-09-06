<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phonebook extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'number',
      
       
    ];

    public function phone()
    {
        return $this->hasOne(Phonebook::class , 'phone_number', 'phone_type');
    }
  
}
