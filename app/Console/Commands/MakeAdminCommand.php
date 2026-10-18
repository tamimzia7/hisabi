<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeAdminCommand extends Command
{
    protected $signature = 'hisabi:make-admin {email}';

    protected $description = 'Grant admin privileges to an existing user by email.';

    public function handle(): int
    {
        $user = User::where('email', $this->argument('email'))->first();

        if (! $user) {
            $this->error('User not found.');

            return self::FAILURE;
        }

        $user->update(['is_admin' => true]);

        $this->info('Admin privileges granted to '.$user->email);

        return self::SUCCESS;
    }
}
