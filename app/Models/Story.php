<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    protected $table = 'stories';

    protected $fillable = [
        'capsule_id',
        'media_type',
        'media_path',
        'duration',
    ];

    // Relacionamento com Capsule
    public function capsule()
    {
        return $this->belongsTo(Capsule::class);
    }
}