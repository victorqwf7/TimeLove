<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Capsule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'theme',
    ];

    /**
     * Relacionamento com o usuário criador da cápsula.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento com os usuários convidados (compartilhamento).
     */
    public function sharedWith()
    {
        return $this->belongsToMany(User::class, 'capsule_user', 'capsule_id', 'user_id');
    }

    /**
     * Relacionamento com os stories dentro da cápsula.
     */
    public function stories()
    {
        return $this->hasMany(Story::class);
    }
}