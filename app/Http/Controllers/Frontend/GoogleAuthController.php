<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the callback from Google.
     */
    public function callback()
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (Exception $e) {
            return redirect('/')->with('error', 'Google authentication failed.');
        }

        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            Auth::login($existingUser);
        } else {
            $prefix = 'CYNTS';
            $lastUser = User::latest('id')->first();
            $nextId = $lastUser ? $lastUser->id + 1 : 1;
            $uniqueId = $prefix . str_pad($nextId, 3, '0', STR_PAD_LEFT);

            $newUser = User::updateOrCreate([
                'email' => $user->email
            ], [
                'user_unique_id' => $uniqueId,
                'user' => $user->avatar,
                'name' => $user->name,
                'password' => bcrypt(Str::random(16)),
                'email_verified_at' => Carbon::now()
            ]);
            Auth::login($newUser);
        }

        return redirect()->route('user.dashboard')->with('success', 'Your logged in successfully!!');
    }
}
