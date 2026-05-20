<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();
        $user->loadMissing('profile');

        return view('profile.edit', [
            'user' => $user,
            'profile' => $user->profile,
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        $user->fill([
            'name' => trim(($data['first_name'] ?? '').' '.($data['last_name'] ?? '')),
            'email' => $data['email'],
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $profileData = collect($data)->only([
            'first_name', 'middle_name', 'last_name', 'graduation_year',
            'current_job', 'industry', 'contact_number', 'bio',
        ])->toArray();

        if ($request->hasFile('profile_picture')) {
            // Remove the previous picture so old files don't pile up in storage.
            if ($user->profile && $user->profile->profile_picture_url) {
                $old = ltrim(parse_url($user->profile->profile_picture_url, PHP_URL_PATH) ?? '', '/');
                $old = preg_replace('#^storage/#', '', $old);
                Storage::disk('public')->delete($old);
            }

            $path = $request->file('profile_picture')->store('profiles', 'public');
            $profileData['profile_picture_url'] = Storage::url($path);
        }

        Profile::updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
