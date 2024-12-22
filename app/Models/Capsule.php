<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capsule extends Model
{
    use HasFactory;

    protected $table = 'capsules';
    protected $fillable = ['user_id', 'name', 'theme'];


    public function stories()
    {
        return $this->hasMany(Story::class);
    }
}