<?php

namespace Orchid\Platform\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Orchid\Platform\Actions\CreateAdminUser;
use Orchid\Platform\Actions\UpdateAdminUser;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'orchid:admin2')]
class OrchidUserCommand extends Command
{
    /**
     * Конфигурация команды.
     */
    protected $signature = 'orchid:admin2 {--id=} {arguments?*}';

    protected $description = 'Create or update an admin user dynamically';

    /**
     * Запуск команды.
     */
    public function handle(): void
    {
        $userId = $this->option('id');

        if ($userId) {
            /** @var UpdateAdminUser $service */
            $service = app(config('orchid.adminTerminalCreator', UpdateAdminUser::class), [
                'command' => $this,
            ]);
        } else {
            /** @var CreateAdminUser $service */
            $service = app(config('orchid.adminTerminalCreator', CreateAdminUser::class), [
                'command' => $this,
            ]);
        }

        try {
            $arguments = $service->prepare(
                $this->parseArguments(),
                $this,
            );

            $service->handle(
                $arguments,
                $this->option('id'),
            );

            $this->info('User created or updated successfully.');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * Обрабатывает вводимые данные.
     */
    private function parseArguments(): Collection
    {
        return collect($this->argument('arguments'))
            ->map(fn (string $arg) => Str::of($arg))
            ->mapWithKeys(function (Stringable $arg) {

                if (! $arg->contains('=')) {
                    return [$arg->toString() => null];
                }

                $explode = $arg->explode('=', 2);

                return [$explode[0] => $explode[1]];
            });
    }
}
