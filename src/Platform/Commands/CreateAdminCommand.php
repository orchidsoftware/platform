<?php

declare(strict_types=1);

namespace Orchid\Platform\Commands;

use Orchid\Platform\Dashboard;
use Illuminate\Console\Command;
use Orchid\Platform\Models\User;
use Illuminate\Database\QueryException;

class CreateAdminCommand extends Command
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
    protected $signature = 'orchid:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create user administrator';

    /**
     * Permissions.
     *
     * @var
     */
    protected $permissions;

    /**
     * CreateAdminCommand constructor.
     *
     * @param Dashboard $dashboard
     */
    public function __construct(Dashboard $dashboard)
    {
        parent::__construct();

        $this->permissions = $dashboard->getPermission()->collapse();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            Dashboard::modelClass(User::class)
                ->createAdmin(
                    $this->ask('What is your name?', 'admin'),
                    $this->ask('What is your email?', 'admin@admin.com'),
                    $this->secret('What is the password?', 'password')
            );

            $this->info('User created successfully.');
        } catch (QueryException $e) {
            $this->error('User already exists or an error occurred!');
            $this->error($e->getMessage());
        }
    }
}
