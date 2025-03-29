<?php

namespace Orchid\Platform\Actions;

use Illuminate\Console\Command;
use Orchid\Platform\Models\User;
use Orchid\Support\Facades\Dashboard;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser
{
    /**
     * @param \Illuminate\Console\Command $command The console command instance (if called from CLI).
     */
    public function __construct(protected Command $command) {}

    /**
     * Update an existing user with the provided attributes.
     *
     * @param string     $id         The user ID.
     * @param Collection $attributes The attributes to update.
     *
     * @return void
     */
    protected function updateUser(string $id, Collection $attributes): void
    {
        $this->model()
            ->findOrFail($id)
            ->forceFill($attributes->all())
            ->save();
    }

    /**
     * Prepare user attributes before creating or updating.
     * If a console command is provided, it will prompt the user for missing attributes.
     *
     * @param Collection      $attributes The provided attributes.
     *
     * @return Collection The prepared attributes.
     */
    public function prepare(Collection $attributes): Collection
    {
        if ($this->command && $attributes->isEmpty()) {
            $attributes = collect([
                'name'     => $this->command->ask('What is your name?', 'admin'),
                'email'    => $this->command->ask('What is your email?', 'admin@admin.com'),
                'password' => $this->command->secret('What is the password?'),
            ]);
        }

        if (!$attributes->has('permissions')) {
            $attributes->put('permissions', Dashboard::getAllowAllPermission());
        }

        if ($attributes->has('password')) {
            $attributes->put('password', Hash::make($attributes['password']));
        }

        return $attributes;
    }

    /**
     * Retrieve the user model used in Orchid.
     *
     * @return User The user model instance.
     */
    protected function model(): User
    {
        return Dashboard::modelClass(User::class);
    }

    /**
     * Create a new user with the provided attributes.
     *
     * @param \ArrayAccess $arguments The user attributes.
     *
     * @return void
     */
    public function handle(\ArrayAccess $arguments): void
    {
        $attributes = $this->prepare(collect($arguments));

        $this->model()->forceFill($attributes->all())->save();
    }
}
