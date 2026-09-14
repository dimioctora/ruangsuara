<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReputationLog extends Model
{
    protected $fillable = [
        'user_id',
        'action_type',
        'xp_change',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
