<?php

namespace Orchid\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Orchid\Core\Models\User;
use Orchid\Kernel\Dashboard;

class CreateAdminCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:admin';

    /**
     * @var string
     */
    protected $signature = 'make:admin {name} {email} {password}';

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

        $this->permissions = $dashboard->permission->get();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $permissions = [];
        foreach ($this->permissions->flatten() as $permission) {
            $permissions[$permission] = 1;
        }

        try {
            User::create([
                'name'        => $this->argument('name'),
                'email'       => $this->argument('email'),
                'password'    => bcrypt($this->argument('password')),
                'permissions' => $permissions,
            ]);

            $this->info('User created successfully.');
        } catch (QueryException $e) {
            $this->error('User already exists or an error occurred!');
            $this->error($e->getMessage());
        }
    }
}
