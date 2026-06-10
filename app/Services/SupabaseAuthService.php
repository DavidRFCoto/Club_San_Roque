<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class SupabaseAuthService
{
    private string $supabaseUrl;
    private string $anonKey;
    private string $serviceKey;

    public function __construct()
    {
        $this->supabaseUrl = config('services.supabase.url');
        $this->anonKey = config('services.supabase.anon_key');
        $this->serviceKey = config('services.supabase.service_key');
    }

    public function login(string $email, string $password): ?User
    {
        $response = Http::withHeaders([
            'apikey' => $this->anonKey,
            'Content-Type' => 'application/json',
        ])->post("{$this->supabaseUrl}/auth/v1/token?grant_type=password", [
            'email' => $email,
            'password' => $password,
        ]);

        if (!$response->successful()) {
            return null;
        }

        $authData = $response->json();

        Session::put('supabase_access_token', $authData['access_token']);
        Session::put('supabase_refresh_token', $authData['refresh_token']);

        $user = User::where('email', $email)->first();

        if (!$user) {
            $metadata = $authData['user']['user_metadata'] ?? [];
            $user = User::create([
                'nombre' => $metadata['full_name'] ?? $email,
                'email' => $email,
                'password' => '',
                'rol' => $metadata['rol'] ?? 'administrador',
                'activo' => true,
            ]);
        }

        $this->setUserSession($user);

        return $user;
    }

    public function register(string $nombre, string $email, string $password, string $rol): ?User
    {
        $response = Http::withHeaders([
            'apikey' => $this->serviceKey,
            'Authorization' => "Bearer {$this->serviceKey}",
            'Content-Type' => 'application/json',
        ])->post("{$this->supabaseUrl}/auth/v1/admin/users", [
            'email' => $email,
            'password' => $password,
            'email_confirm' => true,
            'user_metadata' => [
                'full_name' => $nombre,
                'rol' => $rol,
            ],
        ]);

        if (!$response->successful()) {
            return null;
        }

        $user = User::create([
            'nombre' => $nombre,
            'email' => $email,
            'password' => '',
            'rol' => $rol,
            'activo' => true,
        ]);

        return $user;
    }

    public function logout(): void
    {
        Session::forget(['supabase_access_token', 'supabase_refresh_token', 'supabase_user']);
        Session::flush();
    }

    public function check(): bool
    {
        return Session::has('supabase_user');
    }

    public function user(): ?array
    {
        return Session::get('supabase_user');
    }

    private function setUserSession(User $user): void
    {
        Session::put('supabase_user', [
            'id' => $user->id,
            'nombre' => $user->nombre,
            'email' => $user->email,
            'rol' => $user->rol,
        ]);
    }
}
