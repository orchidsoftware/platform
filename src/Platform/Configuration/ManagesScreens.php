<?php

namespace Orchid\Platform\Configuration;

use Illuminate\Support\Facades\App;
use Orchid\Screen\Screen;

trait ManagesScreens
{
    /**
     * The current screen instance.
     *
     * @var Screen|null
     */
    private ?Screen $currentScreen;

    /**
     * Determines whether the current request is a partial request or not.
     * A partial request is a request that only loads a specific part of the page, such as a modal window or a section of content,
     * instead of loading the entire page.
     *
     * @var bool Set to true if the current request is a partial request, false otherwise.
     */
    private bool $partialRequest = false;

    /**
     * Get the current screen instance.
     *
     * @return Screen|null The current screen instance or null if not set.
     */
    public function getCurrentScreen(): ?Screen
    {
        return $this->currentScreen;
    }

    /**
     * Get the current screen instance.
     *
     * @return $this
     */
    public function setCurrentScreen(Screen $screen, bool $partialRequest = false): self
    {
        $this->currentScreen = $screen;
        $this->partialRequest = $partialRequest;

        App::singleton($screen::class, static fn () => $screen);
        App::rebinding($screen::class, static fn () => app($screen::class));

        return $this;
    }

    /**
     * Determines whether the current request is a partial request or not.
     *
     * A partial request is a request that only loads a specific part of the page, such as a modal window or a section of content,
     * instead of loading the entire page. This method returns a boolean value indicating whether the current request is a partial
     * request or not, based on the value of the $partialRequest property.
     *
     * @return bool True if the current request is a partial request, false otherwise.
     */
    public function isPartialRequest(): bool
    {
        return $this->partialRequest;
    }
}
