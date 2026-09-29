<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\password;
use function Laravel\Prompts\select;
use function Laravel\Prompts\table;
use function Laravel\Prompts\text;

class CreateUser extends Command
{
    protected $signature = 'app:create-user
                            {--name=     : Full name}
                            {--email=    : Email address}
                            {--password= : Password (min 8 chars)}
                            {--role=     : Role: user|admin}
                            {--verify    : Flag kept for compatibility — email is always verified}';

    protected $description = 'Interactively create or update a user (email pre-verified, no mail sent)';

    public function handle(): int
    {
        $this->newLine();
        $this->components->info('FanHub+ — Create / Update User');
        $this->newLine();

        // ── Name ──────────────────────────────────────────────────────────────
        $name = $this->option('name') ?: text(
            label: 'Full name',
            placeholder: 'Jane Doe',
            required: 'Name is required.',
            validate: fn(string $v) => strlen(trim($v)) < 2
                ? 'Name must be at least 2 characters.'
                : null,
        );

        $name = trim($name);

        // ── Email ─────────────────────────────────────────────────────────────
        $email = $this->option('email') ?: text(
            label: 'Email address',
            placeholder: 'jane@example.com',
            required: 'Email is required.',
            validate: fn(string $v) => ! filter_var(trim($v), FILTER_VALIDATE_EMAIL)
                ? 'Please enter a valid email address.'
                : null,
        );

        $email = strtolower(trim($email));

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->components->error("Invalid email address: {$email}");
            return self::FAILURE;
        }

        $exists = User::withTrashed()->where('email', $email)->exists();

        // ── Password ──────────────────────────────────────────────────────────
        if ($this->option('password')) {
            $plain = $this->option('password');

            if (strlen($plain) < 8) {
                $this->components->error('Password must be at least 8 characters.');
                return self::FAILURE;
            }
        } else {
            $plain = password(
                label: 'Password',
                placeholder: 'min. 8 characters',
                required: 'Password is required.',
                validate: fn(string $v) => strlen($v) < 8
                    ? 'Password must be at least 8 characters.'
                    : null,
            );

            $confirmation = password(
                label: 'Confirm password',
                required: 'Please confirm the password.',
            );

            if ($plain !== $confirmation) {
                $this->components->error('Passwords do not match. No changes made.');
                return self::FAILURE;
            }
        }

        // ── Role ──────────────────────────────────────────────────────────────
        $roleOption = $this->option('role');

        if ($roleOption !== null) {
            if (! in_array($roleOption, ['user', 'admin'], true)) {
                $this->components->error("Invalid role '{$roleOption}'. Allowed values: user, admin.");
                return self::FAILURE;
            }
            $role = $roleOption;
        } else {
            $role = select(
                label: 'Role',
                options: [
                    'user'  => 'User  — standard account',
                    'admin' => 'Admin — full control panel access',
                ],
                default: 'user',
            );
        }

        $isAdmin = $role === 'admin';

        // ── Summary table ─────────────────────────────────────────────────────
        $this->newLine();

        table(
            headers: ['Field', 'Value'],
            rows: [
                ['Name',           $name],
                ['Email',          $email],
                ['Password',       str_repeat('•', min(strlen($plain), 16))],
                ['Role',           $isAdmin ? 'Admin' : 'User'],
                ['Email verified', 'Yes (set to now)'],
                ['Action',         $exists ? '⟳  Update existing record' : '＋  Create new user'],
            ],
        );

        $this->newLine();

        // ── Confirm ───────────────────────────────────────────────────────────
        $proceed = confirm(
            label: $exists
                ? "A user with {$email} already exists. Overwrite their name, password, and role?"
                : "Create this user?",
            default: true,
        );

        if (! $proceed) {
            $this->components->warn('Aborted. No changes were made.');
            return self::SUCCESS;
        }

        // ── Persist ───────────────────────────────────────────────────────────
        /** @var User $user */
        $user = User::withTrashed()->updateOrCreate(
            ['email' => $email],
            [
                'name'              => $name,
                'password'          => Hash::make($plain),
                'password_changed_at' => now(),
                'is_admin'          => $isAdmin,
                'email_verified_at' => now(),
                'banned_at'         => null,
                'deleted_at'        => null,
            ],
        );

        // Restore if the record was soft-deleted
        if ($user->trashed()) {
            $user->restore();
        }

        $this->newLine();
        $this->components->success(sprintf(
            'User #%d (%s) %s successfully.',
            $user->id,
            $user->email,
            $exists ? 'updated' : 'created',
        ));
        $this->newLine();

        return self::SUCCESS;
    }
}
