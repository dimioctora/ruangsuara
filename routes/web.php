<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\SuaraController;

Route::get('/', function () {
    $stats = \App\Services\PlatformStatsService::getStats();
    $activeReportsCount = $stats['activeReportsCount'];
    $visitorDisplay = $stats['visitorDisplay'];
    $recentIssues = \App\Models\Suara::where('status', 'published')->with(['user', 'votes.user'])->latest()->take(10)->get();

    return view('welcome', compact('activeReportsCount', 'visitorDisplay', 'recentIssues', 'stats'));
});

Route::get('/suara', function (Request $request) {
    $query = \App\Models\Suara::where(function($q) {
        $q->where('status', 'published')->orWhereNull('status');
    })->with(['user', 'votes.user'])->latest();

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($builder) use ($search) {
            $builder->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('location', 'like', "%{$search}%")
                ->orWhere('category', 'like', "%{$search}%");
        });
    }

    if ($request->filled('category')) {
        $categories = is_array($request->category) ? $request->category : explode(',', $request->category);
        $categories = array_filter($categories);
        if (!empty($categories)) {
            $query->whereIn('category', $categories);
        }
    }

    if ($request->filled('location') && $request->location !== 'Seluruh Indonesia') {
        $query->where('location', 'like', "%{$request->location}%");
    }

    $suaras = $query->paginate(6);

    if ($request->ajax() || $request->wantsJson()) {
        $html = '';
        foreach ($suaras as $m) {
            $html .= view('partials.suara_card', compact('m'))->render();
        }
        return response()->json([
            'html' => $html,
            'hasMore' => $suaras->hasMorePages(),
            'nextPage' => $suaras->currentPage() + 1,
            'total' => $suaras->total(),
            'count' => $suaras->count(),
        ]);
    }

    return view('suara', compact('suaras'));
});

Route::get('/cara-kerja', function () {
    return view('cara_kerja');
});

Route::get('/tentang', function () {
    return view('tentang');
});


Route::get('/suara-detail/{id}', function ($id) {
    $suara = \App\Models\Suara::with(['user.badges', 'missions', 'financeTransactions', 'votes.user', 'comments.user'])->findOrFail($id);

    // 1. Comments
    $comments = \App\Models\SuaraComment::where('suara_id', $suara->id)->with('user.badges')->latest()->get();

    // 2. Related Suaras (same category or location, else latest published)
    $relatedSuaras = \App\Models\Suara::where('id', '!=', $suara->id)
        ->where('status', 'published')
        ->where(function($q) use ($suara) {
            if ($suara->category) {
                $q->where('category', $suara->category);
            }
            if ($suara->location) {
                $q->orWhere('location', $suara->location);
            }
        })
        ->latest()
        ->take(3)
        ->get();

    if ($relatedSuaras->count() < 3) {
        $extra = \App\Models\Suara::where('id', '!=', $suara->id)
            ->where('status', 'published')
            ->whereNotIn('id', $relatedSuaras->pluck('id'))
            ->latest()
            ->take(3 - $relatedSuaras->count())
            ->get();
        $relatedSuaras = $relatedSuaras->concat($extra);
    }

    // 3. Stats for Kontribusi Bersama
    $totalDonation = (float) $suara->financeTransactions()->where('type', 'inbound')->sum('amount');
    $activeMissionsCount = $suara->missions()->where('status', 'active')->count();
    $totalMissionPersonnel = (int) $suara->missions()->sum('target_personnel');
    $totalAksi = max($totalMissionPersonnel, $activeMissionsCount > 0 ? $activeMissionsCount * 10 : 0);

    // 4. Tim Pengawal
    $topSupporters = $suara->votes()->with('user')->where('type', 'pro')->take(3)->get();
    $fieldLeaders = $suara->missions()->with('user')->latest()->take(2)->get();

    return view('suara_detail', compact('suara', 'comments', 'relatedSuaras', 'totalDonation', 'activeMissionsCount', 'totalAksi', 'topSupporters', 'fieldLeaders'));
})->name('suara.detail');

Route::post('/suara/{id}/comment', function (Request $request, $id) {
    $request->validate([
        'comment' => 'required|string|min:3|max:1000',
    ]);

    $user = auth()->user();
    $suara = \App\Models\Suara::findOrFail($id);

    $comment = \App\Models\SuaraComment::create([
        'suara_id' => $suara->id,
        'user_id' => $user->id,
        'comment' => $request->comment,
        'likes_count' => 0,
    ]);

    // Reward XP to commenter
    \App\Services\ReputationService::rewardAction(
        $user,
        'comment_suara',
        'COMMENT_ISSUE',
        5,
        'Memberikan masukan pada diskusi publik isu: ' . $suara->title
    );

    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil dipublikasikan!',
            'comment' => [
                'id' => $comment->id,
                'name' => $user->name,
                'avatar_url' => $user->avatar_url ?? null,
                'comment' => $comment->comment,
                'created_at' => 'Baru saja',
                'likes_count' => 0
            ]
        ]);
    }

    return redirect()->back()->with('success', 'Masukan Anda berhasil dikirim ke diskusi publik!');
})->middleware('auth')->name('suara.comment');

Route::post('/suara-comment/{id}/like', function (Request $request, $id) {
    $comment = \App\Models\SuaraComment::findOrFail($id);
    $comment->increment('likes_count');
    
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'likes_count' => $comment->likes_count
        ]);
    }
    return redirect()->back();
})->middleware('auth')->name('suara.comment.like');

Route::post('/suara/{id}/bookmark', function (Request $request, $id) {
    $user = \Illuminate\Support\Facades\Auth::user();
    $suara = \App\Models\Suara::findOrFail($id);

    $existing = \App\Models\SuaraBookmark::where('user_id', $user->id)
        ->where('suara_id', $suara->id)
        ->first();

    if ($existing) {
        $existing->delete();
        $bookmarked = false;
        $message = 'Isu dihapus dari daftar pantauan.';
    } else {
        \App\Models\SuaraBookmark::create([
            'user_id' => $user->id,
            'suara_id' => $suara->id
        ]);
        $bookmarked = true;
        $message = 'Isu berhasil disimpan untuk dipantau!';
    }

    if ($request->ajax() || $request->wantsJson()) {
        return response()->json([
            'success' => true,
            'bookmarked' => $bookmarked,
            'message' => $message
        ]);
    }

    return redirect()->back()->with('success', $message);
})->middleware('auth')->name('suara.bookmark');

Route::get('/dashboard', function () {
    $user = \App\Models\User::with(['badges', 'reputationLogs'])->find(\Illuminate\Support\Facades\Auth::id());
    $suaras = \App\Models\Suara::where('user_id', $user->id)->latest()->get();
    $savedSuaras = $user->bookmarkedSuaras()->with(['user', 'votes.user'])->latest()->get();
    $levelInfo = \App\Services\ReputationService::getLevelInfo($user->xp);

    // Dynamic Database Stats
    $userVotesCount = \App\Models\SuaraVote::where('user_id', $user->id)->where('type', 'pro')->count();
    $suarasSupporterCount = (int) $suaras->sum('supporter_count');
    $totalSupport = $userVotesCount + $suarasSupporterCount;

    $userDonation = (float) \App\Models\FinanceTransaction::where('user_id', $user->id)
        ->where('type', 'inbound')
        ->sum('amount');
    $suaraDonation = (float) \App\Models\FinanceTransaction::whereIn('suara_id', $suaras->pluck('id'))
        ->where('type', 'inbound')
        ->where('user_id', '!=', $user->id)
        ->sum('amount');
    $totalDonation = $userDonation + $suaraDonation;

    $totalAksi = \App\Models\FieldMission::where(function ($q) use ($user, $suaras) {
        $q->where('user_id', $user->id)
          ->orWhereIn('suara_id', $suaras->pluck('id'));
    })->count();

    $stats = [
        'total_support' => $totalSupport,
        'total_donation' => $totalDonation,
        'total_aksi' => $totalAksi,
        'user_votes_count' => $userVotesCount,
        'saved_suaras_count' => $savedSuaras->count(),
    ];

    $allLevels = \App\Services\ReputationService::getAllLevels();
    $totalUsers = \App\Models\User::count();
    $userRank = \App\Models\User::where('xp', '>', $user->xp)->count() + 1;
    $topUsers = \App\Models\User::orderByDesc('xp')->orderByDesc('trust_score')->take(5)->get();

    return view('dashboard', compact('user', 'suaras', 'savedSuaras', 'levelInfo', 'stats', 'allLevels', 'totalUsers', 'userRank', 'topUsers'));
})->middleware('auth');

Route::get('/login', function () {
    return redirect('/?auth=login');
})->name('login');

Route::get('/signup', function () {
    return redirect('/?auth=signup');
});

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('/signup', [\App\Http\Controllers\AuthController::class, 'register']);
Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);

// Google OAuth Routes
Route::get('/auth/google', [\App\Http\Controllers\AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [\App\Http\Controllers\AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Profile & Avatar Routes
Route::post('/profile/update', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
Route::post('/profile/avatar', [\App\Http\Controllers\ProfileController::class, 'uploadAvatar'])->name('profile.avatar')->middleware('auth');
Route::delete('/profile/avatar', [\App\Http\Controllers\ProfileController::class, 'removeAvatar'])->name('profile.avatar.remove')->middleware('auth');
Route::post('/profile/avatar/remove', [\App\Http\Controllers\ProfileController::class, 'removeAvatar'])->name('profile.avatar.remove.post')->middleware('auth');

Route::post('/create-suara', function (Request $request) {
    $isDraft = $request->input('action_type') === 'draft' || $request->has('save_draft') || $request->input('status') === 'draft';

    if ($isDraft) {
        $request->validate([
            'title' => 'required|string|max:100',
        ]);
        $status = 'draft';
    } else {
        $request->validate([
            'title' => 'required|string|max:100',
            'category' => 'required',
            'location' => 'required',
            'description' => 'required',
            'contribution_type' => 'required',
        ]);
        $status = 'published';
    }

    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('suaras', 'public');
    }

    if ($request->filled('draft_id')) {
        $existing = \App\Models\Suara::where('id', $request->draft_id)->where('user_id', auth()->id())->first();
        if ($existing) {
            $data = [
                'title' => $request->title,
                'category' => $request->category,
                'location' => $request->location,
                'reference_link' => $request->reference_link,
                'description' => $request->description,
                'contribution_type' => $request->contribution_type ?? 'voice',
                'expected_impact' => $request->expected_impact,
                'is_fundraising' => $request->has('is_fundraising'),
                'fund_target' => $request->fund_target,
                'status' => $status,
            ];
            if ($imagePath) {
                $data['image'] = $imagePath;
            }
            $existing->update($data);
            $msg = $status === 'draft' ? 'Draft isu berhasil diperbarui!' : 'Suara berhasil dipublikasikan!';
            return redirect('/dashboard?view=suara')->with('success', $msg);
        }
    }

    \App\Models\Suara::create([
        'user_id' => auth()->id(),
        'title' => $request->title,
        'category' => $request->category,
        'location' => $request->location,
        'reference_link' => $request->reference_link,
        'description' => $request->description,
        'image' => $imagePath,
        'contribution_type' => $request->contribution_type ?? 'voice',
        'expected_impact' => $request->expected_impact,
        'is_fundraising' => $request->has('is_fundraising'),
        'fund_target' => $request->fund_target,
        'status' => $status
    ]);

    $msg = $status === 'draft' ? 'Draft isu berhasil disimpan!' : 'Suara berhasil dipublikasikan!';
    return redirect('/dashboard?view=suara')->with('success', $msg);
})->middleware('auth');

Route::delete('/suara/{id}', function ($id) {
    $suara = \App\Models\Suara::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
    $suara->delete();
    return redirect('/dashboard?view=suara')->with('success', 'Suara / Draft berhasil dihapus!');
})->name('suara.destroy')->middleware('auth');



Route::get('/suara-manage/{id}', function ($id) {
    $suara = \App\Models\Suara::findOrFail($id);
    $user = auth()->user();
    $userIssues = \App\Models\Suara::where('user_id', $user->id)->get();
    $missions = \App\Models\FieldMission::where('suara_id', $id)->latest()->get();
    return view('suara_manage', compact('suara', 'user', 'userIssues', 'missions'));
})->middleware('auth');

Route::post('/suara-manage/{id}/update-stage', function (Request $request, $id) {
    $suara = \App\Models\Suara::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
    $suara->update(['current_stage' => $request->stage]);
    return redirect()->back()->with('success', 'Timeline Suara berhasil diupdate!');
})->middleware('auth');

Route::post('/suara-manage/{id}/deploy-mission', function (Illuminate\Http\Request $request, $id) {
    $request->validate([
        'objective' => 'required',
        'location' => 'required',
        'date' => 'required',
        'time' => 'required',
        'target_personnel' => 'required|min:1',
    ]);

    \App\Models\FieldMission::create([
        'user_id' => auth()->id(),
        'suara_id' => $id,
        'objective' => $request->objective,
        'location' => $request->location,
        'scheduled_at' => \Carbon\Carbon::createFromFormat('d/m/Y H:i', $request->date . ' ' . $request->time),
        'target_personnel' => $request->target_personnel,
        'instructions' => $request->instructions,
        'status' => 'active',
    ]);

    return redirect()->back()->with('success', 'MISSION ACTIVATED: Unit lapangan telah dideploy!');
})->middleware('auth');

Route::post('/suara-manage/{id}/update-issue', function (Illuminate\Http\Request $request, $id) {
    $suara = \App\Models\Suara::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
    $suara->update($request->only(['title', 'category', 'location', 'description', 'reference_link', 'expected_impact']));
    return redirect()->back()->with('success', 'Detail Suara berhasil diperbarui!');
})->middleware('auth');

Route::get('/create-suara', function (Request $request) {
    $user = \App\Models\User::find(\Illuminate\Support\Facades\Auth::id());
    // Level 2 (Partisipan) minimal 100 XP untuk buat isu, KECUALI sudah VERIFIED
    if (!$user->is_verified && $user->xp < 100) {
        return redirect('/dashboard')->with('error', 'Akses Terbatas : Sesuai regulasi Suara, Anda perlu melengkapi verifikasi Profil & Email di menu Pengaturan untuk mulai mempublikasikan Suara');
    }
    $draft = null;
    if ($request->filled('draft_id')) {
        $draft = \App\Models\Suara::where('id', $request->draft_id)->where('user_id', $user->id)->first();
    }
    return view('create_suara', compact('user', 'draft'));
})->middleware('auth');

Route::post('/suara', [SuaraController::class, 'store'])->name('suara.store');
Route::post('/suara/{id}/vote', [SuaraController::class, 'vote'])->name('suara.vote')->middleware('auth');
Route::post('/suara/{id}/oppose', [SuaraController::class, 'oppose'])->name('suara.oppose')->middleware('auth');


// Admin Panel Routes (Simplified for development)
// Admin Panel Routes
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/login', [\App\Http\Controllers\AdminController::class, 'login'])->name('login');
    Route::post('/login', [\App\Http\Controllers\AdminController::class, 'postLogin'])->name('login.post');
    Route::get('/logout', [\App\Http\Controllers\AdminController::class, 'logout'])->name('logout');

    Route::get('/', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::get('/suara', [\App\Http\Controllers\AdminController::class, 'suaras'])->name('suara');
    Route::get('/suara/{suara}/edit', [\App\Http\Controllers\AdminController::class, 'editSuara'])->name('suara.edit');
    Route::post('/suara/{suara}', [\App\Http\Controllers\AdminController::class, 'updateSuara'])->name('suara.update');
    Route::post('/suara/{suara}/status', [\App\Http\Controllers\AdminController::class, 'updateSuaraStatus'])->name('suara.status');
    Route::post('/suara/{suara}/delete', [\App\Http\Controllers\AdminController::class, 'deleteSuara'])->name('suara.delete');
    Route::get('/xp', [\App\Http\Controllers\AdminController::class, 'xpConfig'])->name('xp');
    Route::post('/xp', [\App\Http\Controllers\AdminController::class, 'updateXpConfig'])->name('xp.update');
});

Route::get('/api/stats', function () {
    $stats = \App\Services\PlatformStatsService::getStats();
    return response()->json($stats);
});
