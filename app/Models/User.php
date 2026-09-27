<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'google_id',
        'avatar',
        'password',
        'xp',
        'level',
        'trust_score',
        'role',
        'id_number',
        'phone',
        'address',
        'city',
        'country',
        'tagline',
        'is_verified',
    ];

    public function getAvatarUrlAttribute()
    {
        if (!$this->avatar) {
            return null;
        }
        if (str_starts_with($this->avatar, 'http://') || str_starts_with($this->avatar, 'https://')) {
            return $this->avatar;
        }
        return asset('storage/' . $this->avatar);
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges')->withPivot('earned_at');
    }

    public function bookmarks()
    {
        return $this->hasMany(SuaraBookmark::class);
    }

    public function bookmarkedSuaras()
    {
        return $this->belongsToMany(Suara::class, 'suara_bookmarks', 'user_id', 'suara_id')->withTimestamps();
    }

    public function reputationLogs()
    {
        return $this->hasMany(ReputationLog::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function suaras()
    {
        return $this->hasMany(Suara::class);
    }

    public function votes()
    {
        return $this->hasMany(SuaraVote::class);
    }

    public function fieldMissions()
    {
        return $this->hasMany(FieldMission::class);
    }

    public function financeTransactions()
    {
        return $this->hasMany(FinanceTransaction::class);
    }
}
