<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuaraBookmark extends Model
{
    protected $fillable = [
        'user_id',
        'suara_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function suara()
    {
        return $this->belongsTo(Suara::class);
    }
}
