<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'birth_date',
        'gender',
        'initial_height',
        'initial_weight',
        'initial_body_fat',
        'goal'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
