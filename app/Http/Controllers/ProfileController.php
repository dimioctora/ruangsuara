<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Update user profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'id_number' => ['nullable', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:25'],
            'city' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:500'],
            'country' => ['nullable', 'string', 'max:100'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'avatar_base64' => ['nullable', 'string'],
        ]);

        // Process cropped & compressed base64 avatar if provided
        if (!empty($validated['avatar_base64'])) {
            $this->saveBase64Avatar($user, $validated['avatar_base64']);
        }

        // Check if user completed verification data
        $isVerified = $user->is_verified;
        if (!empty($validated['id_number']) && !empty($validated['phone']) && !empty($validated['address'])) {
            $isVerified = true;
        }

        $user->update([
            'name' => $validated['name'],
            'id_number' => $validated['id_number'] ?? $user->id_number,
            'phone' => $validated['phone'] ?? $user->phone,
            'city' => $validated['city'] ?? $user->city,
            'address' => $validated['address'] ?? $user->address,
            'country' => $validated['country'] ?? $user->country ?? 'Indonesia',
            'tagline' => $validated['tagline'] ?? $user->tagline,
            'is_verified' => $isVerified,
        ]);

        return redirect()->back()->with('success', 'Profil dan identitas Anda berhasil diperbarui!');
    }

    /**
     * Upload & save cropped avatar via AJAX.
     */
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'image' => ['required', 'string'], // base64 data URL
        ]);

        $user = Auth::user();
        $avatarPath = $this->saveBase64Avatar($user, $request->input('image'));

        return response()->json([
            'success' => true,
            'avatar_url' => $user->avatar_url,
            'message' => 'Foto profil berhasil diperbarui!'
        ]);
    }

    /**
     * Remove custom user avatar.
     */
    public function removeAvatar()
    {
        $user = Auth::user();

        if ($user->avatar && !str_starts_with($user->avatar, 'http')) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update(['avatar' => null]);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil dihapus.'
            ]);
        }

        return redirect()->back()->with('success', 'Foto profil berhasil dihapus.');
    }

    /**
     * Helper to process, compress and save base64 image data to public storage.
     */
    private function saveBase64Avatar($user, string $base64Data): string
    {
        // Extract base64 image string
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Data, $type)) {
            $data = substr($base64Data, strpos($base64Data, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, webp, jpeg

            if (!in_array($type, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                $type = 'jpg';
            }

            $data = base64_decode($data);

            if ($data === false) {
                return $user->avatar ?? '';
            }

            // Remove old custom avatar file if stored locally
            if ($user->avatar && !str_starts_with($user->avatar, 'http')) {
                Storage::disk('public')->delete($user->avatar);
            }

            $fileName = 'avatars/' . $user->id . '_' . time() . '_' . Str::random(6) . '.' . ($type === 'png' ? 'png' : 'jpg');
            Storage::disk('public')->put($fileName, $data);

            $user->avatar = $fileName;
            $user->save();

            return $fileName;
        }

        return $user->avatar ?? '';
    }
}
