<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suara extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'category',
        'location',
        'reference_link',
        'description',
        'image',
        'contribution_type',
        'target_voice',
        'supporter_count',
        'opponent_count',
        'expected_impact',
        'status',
        'is_fundraising',
        'fund_target',
        'current_stage',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function missions()
    {
        return $this->hasMany(FieldMission::class);
    }

    public function financeTransactions()
    {
        return $this->hasMany(FinanceTransaction::class);
    }

    public function votes()
    {
        return $this->hasMany(SuaraVote::class);
    }

    public function comments()
    {
        return $this->hasMany(SuaraComment::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(SuaraBookmark::class);
    }

    public function isBookmarkedBy($user = null)
    {
        $userId = $user ? (is_object($user) ? $user->id : $user) : \Illuminate\Support\Facades\Auth::id();
        if (!$userId) return false;
        return $this->bookmarks()->where('user_id', $userId)->exists();
    }
}
