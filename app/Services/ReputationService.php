<?php

namespace App\Services;

use App\Models\User;
use App\Models\ReputationLog;
use App\Models\Badge;

class ReputationService
{
    protected const LEVELS = [
        ['name' => 'Rakyat', 'min_xp' => 0, 'icon' => 'user', 'shape' => 'circle', 'color' => '#9CA3AF'],
        ['name' => 'Partisipan', 'min_xp' => 100, 'icon' => 'message-square', 'shape' => 'circle', 'color' => '#60A5FA'],
        ['name' => 'Kontributor', 'min_xp' => 300, 'icon' => 'pen-tool', 'shape' => 'circle-glow', 'color' => '#3B82F6'],
        ['name' => 'Penggerak', 'min_xp' => 700, 'icon' => 'flame', 'shape' => 'hexagon', 'color' => '#F97316'],
        ['name' => 'Inisiator', 'min_xp' => 1500, 'icon' => 'lightbulb', 'shape' => 'hexagon-glow', 'color' => '#FACC15'],
        ['name' => 'Koordinator', 'min_xp' => 3000, 'icon' => 'compass', 'shape' => 'hexagon-border', 'color' => '#8B5CF6'],
        ['name' => 'Mobilisator', 'min_xp' => 6000, 'icon' => 'megaphone', 'shape' => 'shield', 'color' => '#EF4444'],
        ['name' => 'Strategis', 'min_xp' => 10000, 'icon' => 'layout-grid', 'shape' => 'shield-gradient', 'color' => '#6366F1'],
        ['name' => 'Legislator', 'min_xp' => 15000, 'icon' => 'scale', 'shape' => 'diamond', 'color' => '#10B981'],
        ['name' => 'Lord', 'min_xp' => 25000, 'icon' => 'crown', 'shape' => 'diamond-aura', 'color' => '#F59E0B'],
    ];

    public static function addXp(User $user, int $amount, string $type, string $description = null)
    {
        $user->xp += $amount;
        if ($user->xp < 0) $user->xp = 0;

        ReputationLog::create([
            'user_id' => $user->id,
            'action_type' => $type,
            'xp_change' => $amount,
            'description' => $description,
        ]);

        self::updateLevel($user);
        self::updateTrust($user, $type);
        self::updateRole($user);
        $user->save();
        
        self::checkBadges($user);
    }

    protected static function updateLevel(User $user)
    {
        $currentLevel = 'Rakyat';
        foreach (self::LEVELS as $level) {
            if ($user->xp >= $level['min_xp']) {
                $currentLevel = $level['name'];
            } else {
                break;
            }
        }
        $user->level = $currentLevel;
    }

    protected static function updateTrust(User $user, string $type)
    {
        $change = 0;
        switch ($type) {
            case 'CHECK_IN':
            case 'UPLOAD_PROOF':
                $change = 5;
                break;
            case 'INVALID_REPORT':
                $change = -10;
                break;
            case 'VIOLATION':
                $change = -20;
                break;
            case 'ISSUE_APPROVED':
                $change = 2;
                break;
        }
        $user->trust_score += $change;
        if ($user->trust_score > 100) $user->trust_score = 100;
        if ($user->trust_score < 0) $user->trust_score = 0;
    }

    protected static function updateRole(User $user)
    {
        $levelIndex = 0;
        foreach (self::LEVELS as $index => $level) {
            if ($user->level === $level['name']) {
                $levelIndex = $index + 1;
                break;
            }
        }

        if ($levelIndex === 10 && $user->trust_score > 90) {
            $user->role = 'Elite';
        } elseif ($levelIndex >= 9 && $user->trust_score > 85) {
            $user->role = 'Moderator';
        } elseif ($levelIndex >= 6 && $user->trust_score > 70) {
            $user->role = 'Koordinator';
        } elseif ($user->trust_score > 60) {
            $user->role = 'Verified User';
        } else {
            $user->role = 'Default User';
        }
    }

    protected static function checkBadges(User $user)
    {
        // Simple badge example: First Issue
        if ($user->reputationLogs()->where('action_type', 'CREATE_ISSUE')->count() === 1) {
            self::awardBadge($user, 'First Suara');
        }
    }

    protected static function awardBadge(User $user, string $badgeName)
    {
        $badge = Badge::where('name', $badgeName)->first();
        if ($badge && !$user->badges->contains($badge->id)) {
            $user->badges()->attach($badge->id);
        }
    }
    
    public static function getLevelInfo($xp)
    {
        $current = self::LEVELS[0];
        $next = null;
        
        foreach (self::LEVELS as $index => $level) {
            if ($xp >= $level['min_xp']) {
                $current = $level;
                $next = self::LEVELS[$index + 1] ?? null;
                $current['index'] = $index + 1;
            } else {
                break;
            }
        }
        
        return [
            'current' => $current,
            'next' => $next,
        ];
    }

    public static function getAllLevels()
    {
        return self::LEVELS;
    }
}
