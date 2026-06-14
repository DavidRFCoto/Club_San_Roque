<?php

namespace App\Services;

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

    public function login(string $email, string $password): ?array
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

        $metadata = $authData['user']['user_metadata'] ?? [];
        $userData = [
            'id' => $authData['user']['id'] ?? null,
            'nombre' => $metadata['full_name'] ?? $email,
            'email' => $email,
            'rol' => $metadata['rol'] ?? 'administrador',
            'activo' => true,
        ];

        $this->setUserSession($userData);

        return $userData;
    }

    public function register(string $nombre, string $email, string $password, string $rol): ?array
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

        $responseData = $response->json();
        $userData = [
            'id' => $responseData['user']['id'] ?? null,
            'nombre' => $nombre,
            'email' => $email,
            'rol' => $rol,
            'activo' => true,
        ];

        return $userData;
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

    private function setUserSession(array $userData): void
    {
        Session::put('supabase_user', [
            'id' => $userData['id'],
            'nombre' => $userData['nombre'],
            'email' => $userData['email'],
            'rol' => $userData['rol'],
        ]);
    }
}
