<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FieldMission extends Model
{
    protected $fillable = [
        'user_id',
        'suara_id',
        'objective',
        'location',
        'scheduled_at',
        'target_personnel',
        'instructions',
        'status',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function getScheduledAtAttribute($value)
    {
        if (is_string($value) && preg_match('/^\d{2}\/\d{2}\/\d{4}/', $value)) {
            try {
                return \Carbon\Carbon::createFromFormat('d/m/Y H:i', $value);
            } catch (\Exception $e) {
                return \Carbon\Carbon::parse($value);
            }
        }
        return $this->asDateTime($value);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function suara()
    {
        return $this->belongsTo(Suara::class);
    }
}
