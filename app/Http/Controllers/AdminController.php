<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Suara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login()
    {
        if (Auth::check() && Auth::user()->role === 'Super Admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function postLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role === 'Super Admin') {
                return redirect()->route('admin.dashboard');
            }
            Auth::logout();
            return back()->with('error', 'Akses ditolak: Hanya Super Admin yang dapat masuk ke panel ini.');
        }

        return back()->with('error', 'Email atau password salah.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        if (!Auth::check() || Auth::user()->role !== 'Super Admin') return redirect()->route('admin.login');

        $stats = [
            'total_users' => User::count(),
            'total_suara' => Suara::count(),
            'total_xp' => User::sum('xp'),
            'pending_suara' => Suara::where('status', 'Pending')->count(),
            'total_trust' => round(User::avg('trust_score'), 1),
        ];

        // Recent users & issues
        $recent_users = User::latest()->limit(5)->get();
        $recent_suara = Suara::with('user')->latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_users', 'recent_suara'));
    }

    public function users()
    {
        if (!Auth::check() || Auth::user()->role !== 'Super Admin') return redirect()->route('admin.login');
        $users = User::latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function suaras()
    {
        if (!Auth::check() || Auth::user()->role !== 'Super Admin') return redirect()->route('admin.login');
        $suaras = Suara::with('user')->latest()->paginate(20);
        return view('admin.suaras', compact('suaras'));
    }

    public function updateSuaraStatus(Request $request, Suara $suara)
    {
        if (!Auth::check() || Auth::user()->role !== 'Super Admin') return redirect()->route('admin.login');
        $request->validate([
            'status' => 'required|string|in:Pending,Approved,In Review,Completed,Rejected'
        ]);

        $suara->update(['status' => $request->status]);

        return back()->with('success', 'Status isu berhasil diperbarui.');
    }

    public function editSuara(Suara $suara)
    {
        if (!Auth::check() || Auth::user()->role !== 'Super Admin') return redirect()->route('admin.login');
        return view('admin.edit_suara', compact('suara'));
    }

    public function updateSuara(Request $request, Suara $suara)
    {
        if (!Auth::check() || Auth::user()->role !== 'Super Admin') return redirect()->route('admin.login');
        
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'location' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|max:5120', // Max 5MB
        ]);

        $data = $request->only(['title', 'category', 'location', 'description', 'reference_link', 'expected_impact', 'status', 'supporter_count', 'opponent_count']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('suaras', 'public');
        }

        $suara->update($data);

        return redirect()->route('admin.suara')->with('success', 'Isu berhasil diperbarui.');
    }

    public function deleteSuara(Suara $suara)
    {
        if (!Auth::check() || Auth::user()->role !== 'Super Admin') return redirect()->route('admin.login');
        $suara->delete();
        return back()->with('success', 'Isu berhasil dihapus.');
    }

    public function xpConfig()
    {
        if (!Auth::check() || Auth::user()->role !== 'Super Admin') return redirect()->route('admin.login');
        
        $config = \App\Models\ReputationConfig::all();

        return view('admin.xp_config', compact('config'));
    }

    public function updateXpConfig(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'Super Admin') return redirect()->route('admin.login');

        $request->validate([
            'config' => 'required|array',
            'config.*.id' => 'required|exists:reputation_configs,id',
            'config.*.xp_reward' => 'required|integer|min:0',
            'config.*.trust_bonus' => 'required|numeric|min:0',
        ]);

        foreach ($request->config as $id => $data) {
            \App\Models\ReputationConfig::where('id', $data['id'])->update([
                'xp_reward' => $data['xp_reward'],
                'trust_bonus' => $data['trust_bonus'],
            ]);
        }

        return back()->with('success', 'Konfigurasi XP & Reputasi berhasil diperbarui.');
    }
}
