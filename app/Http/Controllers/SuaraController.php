<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Suara;
use Illuminate\Support\Facades\Auth;

class SuaraController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'reference_link' => 'nullable|url',
            'description' => 'nullable|string',
            'contribution_type' => 'nullable|string',
            'target_voice' => 'nullable|integer',
            'expected_impact' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
        ]);

        $data = $request->except('image');
        
        // Ensure null/empty values don't override database defaults
        if (empty($data['target_voice'])) {
            unset($data['target_voice']);
        }

        $suara = new Suara($data);
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('suara_images', 'public');
            $suara->image = '/storage/' . $path;
        }

        $suara->user_id = Auth::id() ?? 1; // Default to user 1 for now if no auth
        $suara->status = 'published';
        $suara->save();

        // Reputation Reward
        $user = $suara->user;
        if ($user) {
            \App\Services\ReputationService::addXp($user, 20, 'CREATE_ISSUE', 'Membuat Suara baru: ' . $suara->title);
        }

        return redirect('/dashboard')->with('success', 'Suara berhasil dipublikasikan!');
    }

    public function vote(Request $request, $id)
    {
        $user = Auth::user();
        $suara = Suara::findOrFail($id);

        // Check if user already voted
        $existingVote = \App\Models\SuaraVote::where('user_id', $user->id)
            ->where('suara_id', $id)
            ->first();

        if ($existingVote) {
             if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Anda sudah memberikan suara untuk isu ini.'], 403);
            }
            return redirect()->back()->with('error', 'Anda sudah memberikan suara untuk isu ini.');
        }

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            \App\Models\SuaraVote::create([
                'user_id' => $user->id,
                'suara_id' => $id,
                'type' => 'pro'
            ]);

            $suara->increment('supporter_count');
            \Illuminate\Support\Facades\DB::commit();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal memberikan suara.'], 500);
            }
            return redirect()->back()->with('error', 'Gagal memberikan suara.');
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true, 
                'count' => number_format($suara->supporter_count, 0, ',', '.'),
                'total' => number_format($suara->supporter_count + $suara->opponent_count, 0, ',', '.')
            ]);
        }
        
        return redirect()->back()->with('success', 'Dukungan berhasil ditambahkan!');
    }

    public function oppose(Request $request, $id)
    {
        $user = Auth::user();
        $suara = Suara::findOrFail($id);

        // Check if user already voted
        $existingVote = \App\Models\SuaraVote::where('user_id', $user->id)
            ->where('suara_id', $id)
            ->first();

        if ($existingVote) {
             if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Anda sudah memberikan suara untuk isu ini.'], 403);
            }
            return redirect()->back()->with('error', 'Anda sudah memberikan suara untuk isu ini.');
        }

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            \App\Models\SuaraVote::create([
                'user_id' => $user->id,
                'suara_id' => $id,
                'type' => 'contra'
            ]);

            $suara->increment('opponent_count');
            \Illuminate\Support\Facades\DB::commit();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal memberikan sanggahan.'], 500);
            }
            return redirect()->back()->with('error', 'Gagal memberikan sanggahan.');
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true, 
                'count' => number_format($suara->opponent_count, 0, ',', '.'),
                'total' => number_format($suara->supporter_count + $suara->opponent_count, 0, ',', '.')
            ]);
        }
        
        return redirect()->back()->with('success', 'Kontra berhasil ditambahkan!');
    }
}
