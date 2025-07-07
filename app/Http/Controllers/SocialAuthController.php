<?php

namespace App\Http\Controllers;

// app/Http/Controllers/SocialAuthController.php
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class SocialAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            // يمكنك استخدام ->stateless() إذا واجهت مشاكل الجلسة
            $googleUser = Socialite::driver('google')->user();

            // ابحث عن المستخدم أو أنشئه
            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt(Str::random(24)), // كلمة مرور مؤقتة
                ]
            );

            // إسناد الدور إن لم يكن لديه أي دور
            if (!$user->hasAnyRole(['user', 'admin', 'sheikh'])) {
                $user->assignRole('user');
            }

            // تسجيل الدخول
            Auth::login($user);

            return redirect()->route('dashboard'); // أو أي صفحة أخرى
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'فشل تسجيل الدخول عبر Google: ' . $e->getMessage());
        }
    }
}
