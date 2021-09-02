<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Pricing extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'sdn',
        'rate',
        'type'
    ];

   
        public function prices()
        {
            return $this->hasMany(Pricing::class);
        }
       
}
