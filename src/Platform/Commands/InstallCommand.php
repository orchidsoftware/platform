<?php

declare(strict_types=1);

namespace Orchid\Platform\Commands;

use Orchid\Platform\Updates;
use Orchid\Platform\Dashboard;
use Illuminate\Console\Command;
use Orchid\Platform\Events\InstallEvent;
use Symfony\Component\Console\Helper\ProgressBar;
use Orchid\Platform\Providers\FoundationServiceProvider;

class InstallCommand extends Command
{
    /**
     * @var ProgressBar
     */
    protected $progressBar;

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

        $this->progressBar = $this->output->createProgressBar(6);

        $this->info("
        ________________________________________________________________
               ____    _____     _____   _    _   _____   _____
              / __ \  |  __ \   / ____| | |  | | |_   _| |  __ \
             | |  | | | |__) | | |      | |__| |   | |   | |  | |
             | |  | | |  _  /  | |      |  __  |   | |   | |  | |
             | |__| | | | \ \  | |____  | |  | |  _| |_  | |__| |
              \____/  |_|  \_\  \_____| |_|  |_| |_____| |_____/

                             Installation started. Please wait...
                             Version: $updates->currentVersion
        ________________________________________________________________
        ");

        sleep(1);

        $this
            ->checkInstall()
            ->executeCommand('migrate')
            ->executeCommand('vendor:publish',
                [
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
                ], ])
            ->executeCommand('migrate')
            ->executeCommand('storage:link');

        $this->changeUserModel();
        $this->progressBar->finish();
        $this->info(' Completed!');

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
        if (! $this->progressBar->getProgress()) {
            $this->progressBar->start();
        }

        $result = $this->call($command, $parameters);
        if ($result) {
            $parameters = http_build_query($parameters, '', ' ');
            $parameters = str_replace('%5C', '/', $parameters);
            $this->alert("An error has occurred. The '{$command} {$parameters}' command was not executed");
        }

        $this->progressBar->advance();

        // Visually slow down the installation process so that the user can read what's happening
        usleep(350000);

        return $this;
    }

    private function changeUserModel()
    {
        $this->progressBar->advance();

        $this->info(' Attempting to set ORCHID User model as parent to App\User');

        if (! file_exists(app_path('User.php'))) {
            $this->warn('Unable to locate "app/User.php".  Did you move this file?');
            $this->warn('You will need to update this manually.  Change "extends Authenticatable" to "extends \Orchid\Platform\Models\User" in your User model');

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
    private function setValueEnv($constant, $value = 'null'): self
    {
        $str = $this->fileGetContent(app_path('../.env'));

        if ($str !== false && strpos($str, $constant) === false) {
            file_put_contents(app_path('../.env'), $str.PHP_EOL.$constant.'='.$value.PHP_EOL);
        }

        return $this;
    }

    /**
     * @return InstallCommand
     */
    private function checkInstall(): self
    {
        if (! file_exists(app_path('Orchid'))) {
            return $this;
        }

        $confirm = $this->confirm('The platform has already been installed, do you really want to repeat?');

        if (! $confirm) {
            exit(0);
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
