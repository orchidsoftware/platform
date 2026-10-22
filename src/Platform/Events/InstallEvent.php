<?php

declare(strict_types=1);

namespace Orchid\Platform\Events;

use Illuminate\Console\Command;

/**
 * Class InstallEvent.
 */
class InstallEvent
{
    /**
     * InstallEvent constructor.
     *
     * @param Command $command
     */
    public function __construct(public Command $command) {}
}
