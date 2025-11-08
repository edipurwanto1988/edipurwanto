<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class MD5AuthService
{
    /**
     * Authenticate user with MD5 password validation
     *
     * @param string $email
     * @param string $password
     * @return User
     * @throws ValidationException
     */
    public function authenticate(string $email, string $password): User
    {
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            throw ValidationException::withMessages([
                'email' => 'Email tidak ditemukan.',
            ]);
        }
        
        // Check if password is stored as MD5 (32 character hex string)
        if (ctype_xdigit($user->password) && strlen($user->password) === 32) {
            // Password is stored as MD5, compare with MD5 hash of input
            if (md5($password) !== $user->password) {
                throw ValidationException::withMessages([
                    'email' => 'Password salah.',
                ]);
            }
        } else {
            // For backward compatibility, check with Laravel's hash verification
            if (!Hash::check($password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => 'Password salah.',
                ]);
            }
        }
        
        return $user;
    }
    
    /**
     * Create MD5 hash of password
     *
     * @param string $password
     * @return string
     */
    public function createMD5Hash(string $password): string
    {
        return md5($password);
    }
    
    /**
     * Login user and create session
     *
     * @param User $user
     * @return bool
     */
    public function login(User $user): bool
    {
        Auth::login($user);
        return true;
    }
}