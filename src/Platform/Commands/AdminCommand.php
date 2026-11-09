<?php

declare(strict_types=1);

namespace Orchid\Platform\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Console\ManuallyFailedException;
use Illuminate\Database\QueryException;
use Orchid\Platform\Models\User;
use Orchid\Support\Facades\Orchid;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'orchid:admin')]
class AdminCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'orchid:admin';

    /**
     * @var string
     */
    protected $signature = 'orchid:admin {name?} {email?} {password?} {--id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or update admin user';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            $userId = $this->option('id');

            empty($userId)
                ? $this->createNewUser()
                : $this->updateUserPermissions((string) $userId);
        } catch (Exception|QueryException $e) {
            throw new ManuallyFailedException($e->getMessage(), previous: $e);
        }
    }

    /**
     * Create a new user administrator.
     */
    protected function createNewUser(): void
    {
        Orchid::modelClass(User::class)
            ->createAdmin(
                $this->argument('name') ?? $this->ask('What is your name?', 'admin'),
                $this->argument('email') ?? $this->ask('What is your email?', 'admin@admin.com'),
                $this->argument('password') ?? $this->secret('What is the password?')
            );

        $this->info('User created successfully.');
    }

    /**
     * Update the permissions of an existing user.
     */
    protected function updateUserPermissions(string $id): void
    {
        Orchid::modelClass(User::class)
            ->findOrFail($id)
            ->forceFill([
                'permissions' => Orchid::allowedPermissions(),
            ])
            ->save();

        $this->info('User permissions updated.');
    }
}
