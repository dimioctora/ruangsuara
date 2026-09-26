<?php

namespace App\Services;

use App\Models\Suara;
use App\Models\SuaraVote;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PlatformStatsService
{
    /**
     * Get real-time aggregated platform statistics & activity feed
     */
    public static function getStats(): array
    {
        // 1. Total Issues (All created issues) & Published Issues
        $totalIssues = Suara::count();
        $publishedCount = Suara::where('status', 'published')->count();

        // 2. Case Closed (All-time completed/resolved/closed issues)
        $caseClosed = Suara::whereIn('current_stage', [4, 5])
            ->orWhereIn('status', ['completed', 'resolved', 'closed'])
            ->count();

        // 3. Supporters count: real supporters + votes + unique visitors
        $suarasSupporters = (int) Suara::sum('supporter_count');
        $votesCount = Schema::hasTable('suara_votes') ? SuaraVote::where('type', 'pro')->count() : 0;
        $visitorsCount = Schema::hasTable('visitors') ? DB::table('visitors')->count() : 0;
        
        $totalSupporters = $suarasSupporters + $votesCount + $visitorsCount;

        // Format Supporter Display (e.g. 29.5K+ or exact number)
        if ($totalSupporters >= 1000000) {
            $val = $totalSupporters / 1000000;
            $decimals = (round($val, 1) != round($val)) ? 1 : 0;
            $supporterDisplay = number_format($val, $decimals, '.', '') . 'M+';
        } elseif ($totalSupporters >= 1000) {
            $val = $totalSupporters / 1000;
            $decimals = (round($val, 1) != round($val)) ? 1 : 0;
            $supporterDisplay = number_format($val, $decimals, '.', '') . 'K+';
        } else {
            $supporterDisplay = number_format($totalSupporters, 0, ',', '.') . '+';
        }

        // 4. Real-time Activity Feed from DB
        $activities = self::getRecentActivities();

        return [
            'totalIssues' => number_format($totalIssues, 0, ',', '.'),
            'caseClosed' => number_format($caseClosed, 0, ',', '.'),
            'rawTotalIssues' => $totalIssues,
            'rawCaseClosed' => $caseClosed,
            'activeReportsCount' => number_format($publishedCount, 0, ',', '.'),
            'visitorDisplay' => $supporterDisplay,
            'rawActive' => $publishedCount,
            'rawSupporters' => $totalSupporters,
            'publishedReports' => $publishedCount,
            'totalVotes' => $votesCount,
            'activities' => $activities,
            'updatedAt' => now()->toIso8601String()
        ];
    }

    /**
     * Build real-time activity log from real database events
     */
    public static function getRecentActivities(): array
    {
        $activities = [];

        // 1. Recent Suara creations
        $recentSuaras = Suara::with('user')->latest()->take(4)->get();
        foreach ($recentSuaras as $suara) {
            $userName = $suara->user->name ?? 'Warga';
            $activities[] = [
                'type' => 'suara',
                'dot_color' => 'bg-accent',
                'title' => $userName . ' mendaftarkan inisiatif: "' . \Illuminate\Support\Str::limit($suara->title, 45) . '"',
                'time' => $suara->created_at ? $suara->created_at->locale('id')->diffForHumans() : 'Baru saja',
                'timestamp' => $suara->created_at ? $suara->created_at->timestamp : time()
            ];
        }

        // 2. Recent Votes
        if (Schema::hasTable('suara_votes')) {
            $recentVotes = SuaraVote::with(['user', 'suara'])->latest()->take(4)->get();
            foreach ($recentVotes as $vote) {
                $userName = $vote->user->name ?? 'Pendukung';
                $suaraTitle = $vote->suara->title ?? 'kampanye warga';
                $activities[] = [
                    'type' => 'vote',
                    'dot_color' => 'bg-success',
                    'title' => $userName . ' mendukung "' . \Illuminate\Support\Str::limit($suaraTitle, 40) . '"',
                    'time' => $vote->created_at ? $vote->created_at->locale('id')->diffForHumans() : 'Baru saja',
                    'timestamp' => $vote->created_at ? $vote->created_at->timestamp : time()
                ];
            }
        }

        // 3. Recent Field Missions
        if (Schema::hasTable('field_missions')) {
            $recentMissions = \App\Models\FieldMission::with('suara')->latest()->take(3)->get();
            foreach ($recentMissions as $mission) {
                $activities[] = [
                    'type' => 'mission',
                    'dot_color' => 'bg-warning',
                    'title' => 'Aksi nyata "' . \Illuminate\Support\Str::limit($mission->objective, 40) . '" dijadwalkan',
                    'time' => $mission->created_at ? $mission->created_at->locale('id')->diffForHumans() : 'Baru saja',
                    'timestamp' => $mission->created_at ? $mission->created_at->timestamp : time()
                ];
            }
        }

        // 4. Recent Finance Donations
        if (Schema::hasTable('finance_transactions')) {
            $recentDonations = \App\Models\FinanceTransaction::with('suara')
                ->where('type', 'inbound')
                ->latest()
                ->take(3)
                ->get();
            foreach ($recentDonations as $donation) {
                $formattedAmount = 'Rp ' . number_format($donation->amount, 0, ',', '.');
                $activities[] = [
                    'type' => 'donation',
                    'dot_color' => 'bg-orange-500',
                    'title' => 'Donasi ' . $formattedAmount . ' disalurkan untuk logistik',
                    'time' => $donation->created_at ? $donation->created_at->locale('id')->diffForHumans() : 'Baru saja',
                    'timestamp' => $donation->created_at ? $donation->created_at->timestamp : time()
                ];
            }
        }

        // Sort by timestamp descending
        usort($activities, function ($a, $b) {
            return $b['timestamp'] <=> $a['timestamp'];
        });

        return array_slice($activities, 0, 3);
    }
}
