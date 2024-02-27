<?php

declare(strict_types=1);

namespace Orchid\Screen\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Orchid\Screen\Contracts\Actionable;
use Orchid\Screen\Repository;
use Orchid\Support\Color;

/**
 * Class Menu
 *
 * @method Menu divider(bool $enabled = true)
 * @method Menu icon(string $icon = null)
 * @method Menu class(string $classes = null)
 * @method Menu parameters(array|object $name)
 * @method Menu target(string $target = null)
 * @method Menu download($download = true)
 * @method Menu href(string $url = true)
 * @method Menu sort(int $weight = 1)
 * @method Menu active(string|array $active = null)
 */
class Menu extends Link
{
    /**
     * @var string
     */
    protected $view = 'platform::actions.menu';

    /**
     * @var bool
     */
    protected $permit = true;

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'class'          => 'nav-link d-flex align-items-center collapsed',
        'title'          => null,
        'icon'           => null,
        'href'           => null,
        'turbo'          => true,
        'list'           => [],
        'source'         => null,
        'divider'        => false,
        'active'         => null,
        'data-bs-toggle' => null,
        'parent'         => null,
        'sort'           => 0,
        'slug'           => null,
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    public $inlineAttributes = [
        'autofocus',
        'disabled',
        'tabindex',
        'href',
        'target',
        'title',
        'download',
        'data-bs-toggle',
    ];

    /**
     * Menu constructor.
     */
    public function __construct()
    {
        $this
            ->addBeforeRender(function () {
                $href = $this->get('href');

                if ($href !== null) {
                    return;
                }

                $slug = $this->getSlug();

                $this
                    ->set('data-bs-toggle', 'collapse')
                    ->set('href', '#menu-'.$slug);
            })
            ->addBeforeRender(function () {
                if ($this->get('active') !== null) {
                    return;
                }

                $active = collect([])
                    ->merge($this->get('list'))
                    ->map(fn (Menu $menu) => $menu->get('href'))
                    ->push($this->get('href'))
                    ->filter()
                    ->map(fn ($href) => [
                        $href,
                        $href.'?*',
                        $href.'/*',
                    ])
                    ->flatten();

                $this->set('active', $active->toArray());
            });
    }

    protected function getSlug(): string
    {
        return $this->get('slug', Str::slug(__($this->get('name'))));
    }

    /**
     * @param Actionable[] $list
     *
     * @return $this
     */
    public function list(array $list): self
    {
        $default = $this->get('list', []);

        $subMenu = collect()
            ->merge($default)
            ->merge($list)
            ->sort(fn (Menu $menu) => $menu->get('sort', 0));

        return $this->set('list', $subMenu);
    }

    /**
     * @throws \Throwable
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function build(?Repository $repository = null)
    {
        $this->set('source', $repository);

        return $this->render();
    }

    /**
     * @return $this
     */
    public function badge(\Closure $badge, Color $color = Color::PRIMARY): self
    {
        $this->set('badge', [
            'class' => $color->name(),
            'data'  => $badge,
        ]);

        return $this;
    }

    /**
     * @return $this
     */
    public function url(string $url): self
    {
        return $this->set('href', $url);
    }

    /**
     * @param string|string[] $permission
     *
     * @return $this
     */
    public function permission($permission = null): self
    {
        $user = Auth::user();

        if ($permission !== null) {
            $this->permit = false;
        }

        if ($user === null) {
            return $this;
        }

        $this->permit = $user->hasAnyAccess($permission);

        return $this;
    }

    public function isSee(): bool
    {
        return parent::isSee() && $this->permit;
    }

    /**
     * @return $this
     */
    public function title(?string $title = null): self
    {
        return $this->set('title', $title);
    }

    /**
     * @return $this
     */
    public function slug(string $slug): self
    {
        return $this->set('slug', $slug);
    }

    /**
     * @return $this
     */
    public function parent(string $parent): self
    {
        return $this->set('parent', $parent);
    }
}
