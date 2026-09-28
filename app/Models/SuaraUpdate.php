<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuaraUpdate extends Model
{
    protected $fillable = [
        'suara_id',
        'user_id',
        'title',
        'content',
        'stage',
        'image',
        'reference_link',
        'is_official',
    ];

    protected $casts = [
        'is_official' => 'boolean',
        'stage' => 'integer',
    ];

    public function suara()
    {
        return $this->belongsTo(Suara::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }
        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }
}
