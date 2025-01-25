<?php

namespace Orchid\Screen\Layouts;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;
use Orchid\Screen\Builder;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;
use Orchid\Support\Facades\Dashboard;

abstract class Listener extends Layout
{

    protected string $template = 'platform::layouts.listener';

    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected array $targets = [];

    /**
     * @return array
     */
    abstract protected function layouts(): iterable;

    /**
     * @param Repository $repository
     * @param Request $request
     *
     * @return Repository
     */
    abstract public function handle(Repository $repository, Request $request): Repository;

    /**
     * @param Repository $repository
     * @return View|null
     */
    public function build(Repository $repository): ?View
    {
        if (! $this->isSee()) {
            return null;
        }

        $this->query = $repository;
        $this->layouts = $this->layouts();

        $this->variables = array_merge($this->variables, [
            'targets'    => collect($this->targets)->map(fn ($target) => Builder::convertDotToArray($target))->toJson(),
            'asyncRoute' => $this->asyncRoute(),
        ]);

        return $this->buildAsDeep($repository);
    }

    /**
     * Returns the system layer name.
     * Required to define an asynchronous layer.
     */
    public function getSlug(): string
    {
        return sha1(static::class);
    }

    /**
     * Return URL for screen template requests from the browser.
     */
    protected function asyncRoute(): ?string
    {
        $screen = Dashboard::getCurrentScreen();

        if (! $screen) {
            return null;
        }

        return route('platform.async.listener', [
            'screen' => Crypt::encryptString(get_class($screen)),
            'layout' => Crypt::encryptString(static::class),
        ]);
    }
}
