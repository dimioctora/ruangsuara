<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\SuaraController;

Route::get('/', function () {
    $stats = \App\Services\PlatformStatsService::getStats();
    $activeReportsCount = $stats['activeReportsCount'];
    $visitorDisplay = $stats['visitorDisplay'];
    $recentIssues = \App\Models\Suara::where('status', 'published')->latest()->take(10)->get();

    return view('welcome', compact('activeReportsCount', 'visitorDisplay', 'recentIssues', 'stats'));
});

Route::get('/suara', function () {
    $suaras = \App\Models\Suara::latest()->get();
    return view('suara', compact('suaras'));
});

Route::get('/cara-kerja', function () {
    return view('cara_kerja');
});

Route::get('/tentang', function () {
    return view('tentang');
});


Route::get('/suara-detail/{id}', function ($id) {
    $suara = \App\Models\Suara::findOrFail($id);
    return view('suara_detail', compact('suara'));
})->name('suara.detail');

Route::get('/dashboard', function () {
    $user = \App\Models\User::with(['badges', 'reputationLogs'])->find(\Illuminate\Support\Facades\Auth::id());
    $suaras = \App\Models\Suara::where('user_id', $user->id)->latest()->get();
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
    ];

    $allLevels = \App\Services\ReputationService::getAllLevels();
    $totalUsers = \App\Models\User::count();
    $userRank = \App\Models\User::where('xp', '>', $user->xp)->count() + 1;
    $topUsers = \App\Models\User::orderByDesc('xp')->orderByDesc('trust_score')->take(5)->get();

    return view('dashboard', compact('user', 'suaras', 'levelInfo', 'stats', 'allLevels', 'totalUsers', 'userRank', 'topUsers'));
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

Route::post('/create-suara', function (Request $request) {
    $validated = $request->validate([
        'title' => 'required|string|max:100',
        'category' => 'required',
        'location' => 'required',
        'description' => 'required',
        'contribution_type' => 'required',
    ]);

    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('suaras', 'public');
    }

    \App\Models\Suara::create([
        'user_id' => auth()->id(),
        'title' => $request->title,
        'category' => $request->category,
        'location' => $request->location,
        'reference_link' => $request->reference_link,
        'description' => $request->description,
        'image' => $imagePath,
        'contribution_type' => $request->contribution_type,
        'expected_impact' => $request->expected_impact,
        'is_fundraising' => $request->has('is_fundraising'),
        'fund_target' => $request->fund_target,
        'status' => 'published' // Default to published for now as requested
    ]);

    return redirect('/dashboard?view=suara')->with('success', 'Suara berhasil dipublikasikan!');
})->middleware('auth');



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

Route::get('/create-suara', function () {
    $user = \App\Models\User::find(\Illuminate\Support\Facades\Auth::id());
    // Level 2 (Partisipan) minimal 100 XP untuk buat isu, KECUALI sudah VERIFIED
    if (!$user->is_verified && $user->xp < 100) {
        return redirect('/dashboard')->with('error', 'Akses Terbatas : Sesuai regulasi Suara, Anda perlu melengkapi verifikasi Profil & Email di menu Pengaturan untuk mulai mempublikasikan Suara');
    }
    return view('create_suara', compact('user'));
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
