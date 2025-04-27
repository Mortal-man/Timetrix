<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Validate inputs
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[\pL\s]+$/u'], // Only letters and spaces allowed
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'current_password' => ['required'],
            'new_password' => ['nullable', 'confirmed', PasswordRule::defaults()],
            'profile_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // 2MB max image size
            'remove_profile_picture' => ['nullable', 'boolean'], // For removal flag
        ]);

        // Check if current password matches
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'The provided password does not match our records.']);
        }

        $emailChanged = $user->email !== $validated['email'];
        $passwordChanged = !empty($validated['new_password']);
        $profilePictureChanged = $request->hasFile('profile_picture');
        $removeProfilePicture = $request->remove_profile_picture;

        // Update basic profile info
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($emailChanged) {
            $user->email_verified_at = null; // Force re-verification
        }

        if ($passwordChanged) {
            $user->password = bcrypt($validated['new_password']);
        }

        // Remove profile picture if requested
        if ($removeProfilePicture) {
            if ($user->profile_picture) {
                Storage::delete($user->profile_picture);
            }
            $user->profile_picture = null;
        }

        // Update profile picture if provided
        if ($profilePictureChanged) {
            // Delete old profile picture if exists
            if ($user->profile_picture) {
                Storage::delete($user->profile_picture);
            }

            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures');
            $user->profile_picture = $profilePicturePath;
        }

        $user->save();

        // Redirect logic based on changes
        if ($emailChanged || $passwordChanged) {
            // Force logout after sensitive updates
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Redirect to login with proper status
            return redirect()->route('login')->with('status', 'Your profile was updated successfully. Please log in again.');
        } else {
            // Only show notification for name and profile picture changes
            return back()->with('status', 'Your profile has been updated successfully.');
        }
    }

    public function validatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
        ]);

        if (Hash::check($request->current_password, auth()->user()->password)) {
            return response()->json(['valid' => true]);
        } else {
            return response()->json(['valid' => false]);
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        // Delete profile picture if exists
        if ($user->profile_picture) {
            Storage::delete($user->profile_picture);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
