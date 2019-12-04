<?php

declare(strict_types=1);

namespace Orchid\Platform\Commands;

use Illuminate\Console\Command;
use Orchid\Platform\Dashboard;
use Orchid\Platform\Events\InstallEvent;
use Orchid\Platform\Providers\FoundationServiceProvider;
use Orchid\Platform\Updates;

class InstallCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'orchid:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish files for ORCHID and install package';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $updates = new Updates();
        $updates->updateInstall();

        $this->info('Installation started. Please wait...');
        $this->info("Version: $updates->currentVersion");

        $this
            ->executeCommand('migrate')
            ->executeCommand('vendor:publish', [
                '--force' => true,
                '--tag'   => 'migrations',
            ])
            ->executeCommand('vendor:publish', [
                '--provider' => FoundationServiceProvider::class,
                '--force'    => true,
                '--tag'      => [
                    'config',
                    'migrations',
                    'orchid-stubs',
                ],])
            ->executeCommand('migrate')
            ->executeCommand('storage:link', [
                '--force' => true,
            ])
            ->changeUserModel();


        $this->info('Completed!');

        $this
            ->setValueEnv('SCOUT_DRIVER')
            ->comment("To create a user, run 'artisan orchid:admin'");

        $this->line("To start the embedded server, run 'artisan serve'");

        event(new InstallEvent($this));
    }

    /**
     * @param string $command
     * @param array  $parameters
     *
     * @return $this
     */
    private function executeCommand(string $command, array $parameters = []): self
    {
        $result = $this->call($command, $parameters);

        if ($result) {
            $parameters = http_build_query($parameters, '', ' ');
            $parameters = str_replace('%5C', '/', $parameters);
            $this->alert("An error has occurred. The '{$command} {$parameters}' command was not executed");
        }

        return $this;
    }

    private function changeUserModel()
    {
        $this->info('Attempting to set ORCHID User model as parent to App\User');

        if (! file_exists(app_path('User.php'))) {
            $this->warn('Unable to locate "app/User.php".  Did you move this file?');
            $this->warn('You will need to update this manually.');
            $this->warn('Change "extends Authenticatable" to "extends \Orchid\Platform\Models\User" in your User model');

            return;
        }

        $user = file_get_contents(Dashboard::path('install-stubs/User.stub'));
        file_put_contents(app_path('User.php'), $user);
    }

    /**
     * @param string $constant
     * @param string $value
     *
     * @return InstallCommand
     */
    private function setValueEnv(string $constant, string $value = 'null'): self
    {
        $str = $this->fileGetContent(app_path('../.env'));

        if ($str !== false && strpos($str, $constant) === false) {
            file_put_contents(app_path('../.env'), $str.PHP_EOL.$constant.'='.$value.PHP_EOL);
        }

        return $this;
    }

    /**
     * @param string $file
     *
     * @return false|string
     */
    private function fileGetContent(string $file)
    {
        if (! is_file($file)) {
            return '';
        }

        return file_get_contents($file);
    }
}
