<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    public function education()
    {
        return $this->hasOne(Education::class);
    }
    public function fees()
    {
        return $this->hasMany(Fee::class);
    }

}
