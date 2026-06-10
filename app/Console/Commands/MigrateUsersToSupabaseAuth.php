<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class MigrateUsersToSupabaseAuth extends Command
{
    protected $signature = 'supabase:migrate-users';
    protected $description = 'Migra usuarios existentes de la tabla public.usuarios a Supabase Auth';

    public function handle(): int
    {
        $serviceKey = config('services.supabase.service_key');
        $supabaseUrl = config('services.supabase.url');

        if (!$serviceKey || !$supabaseUrl) {
            $this->error('Faltan SUPABASE_SERVICE_KEY o SUPABASE_URL en .env');
            return Command::FAILURE;
        }

        $users = User::where('password', '!=', '')->get();

        if ($users->isEmpty()) {
            $this->info('No hay usuarios para migrar.');
            return Command::SUCCESS;
        }

        $bar = $this->output->createProgressBar($users->count());
        $bar->start();

        foreach ($users as $user) {
            $response = Http::withHeaders([
                'apikey' => $serviceKey,
                'Authorization' => "Bearer $serviceKey",
                'Content-Type' => 'application/json',
            ])->post("$supabaseUrl/auth/v1/admin/users", [
                'email' => $user->email,
                'password' => $user->password,
                'email_confirm' => true,
                'user_metadata' => [
                    'full_name' => $user->nombre,
                    'rol' => $user->rol,
                ],
            ]);

            if ($response->successful()) {
                $this->line("  OK: {$user->email}");
            } else {
                $this->warn("  Fallo: {$user->email} - {$response->body()}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Migracion completada.');

        return Command::SUCCESS;
    }
}
