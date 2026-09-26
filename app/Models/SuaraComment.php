<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuaraComment extends Model
{
    protected $fillable = [
        'suara_id',
        'user_id',
        'comment',
        'likes_count',
    ];

    public function suara()
    {
        return $this->belongsTo(Suara::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
