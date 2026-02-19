<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create
                            {--email= : Admin email (or ADMIN_EMAIL env)}
                            {--password= : Admin password (or ADMIN_PASSWORD env)}
                            {--name= : Admin name (default: Admin)}';

    protected $description = 'Create or update the admin user from env vars or arguments';

    public function handle(): int
    {
        $email = $this->option('email') ?: env('ADMIN_EMAIL');
        $password = $this->option('password') ?: env('ADMIN_PASSWORD');
        $name = $this->option('name') ?: env('ADMIN_NAME', 'Admin');

        if (!$email || !$password) {
            $this->error('Missing ADMIN_EMAIL or ADMIN_PASSWORD. Set them in .env or pass as options.');
            return 1;
        }

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'is_admin' => true,
            ]
        );

        $this->info("Admin user ready: {$user->email}");
        return 0;
    }
}
