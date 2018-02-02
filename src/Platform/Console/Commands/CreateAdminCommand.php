<?php

declare(strict_types=1);

namespace Orchid\Platform\Console\Commands;

use Illuminate\Console\Command;
use Orchid\Platform\Core\Models\User;
use Orchid\Platform\Kernel\Dashboard;
use Illuminate\Database\QueryException;

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
    public function handle()
    {
        $permissions = collect();

        $this->permissions->each(function ($items) use ($permissions) {
            foreach ($items as $item) {
                $permissions->put($item['slug'], true);
            }
        });

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
