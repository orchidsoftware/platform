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
     * The view associated with this menu item.
     *
     * @var string
     */
    protected $view = 'platform::actions.menu';

    /**
     * Determines whether the menu item should be displayed based on permissions.
     *
     * @var bool
     */
    protected $permit = true;

    /**
     * Default attributes for the menu item.
     * This includes CSS classes, title, icon, URL, and other options.
     *
     * @var array
     */
    protected $attributes = [
        'class'          => 'nav-link d-flex align-items-center collapsed icon-link',
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
     * Initializes the menu and sets default behaviors for rendering.
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
                    ->set('slug', $slug)
                    ->set('data-bs-toggle', 'collapse')
                    ->set('href', '#menu-'.$slug);
            })
            ->addBeforeRender(function () {
                if ($this->get('active') !== null) {
                    return;
                }

                $active = collect()
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

    /**
     * Generates a slug for the menu item based on its name.
     *
     * @return string The generated slug.
     */
    protected function getSlug(): string
    {
        return $this->get('slug', Str::slug($this->get('name')));
    }

    /**
     * Sets a list of sub-menu items for this menu item.
     *
     * @param Actionable[] $list The array of sub-menu items.
     *
     * @return $this The current Menu instance for method chaining.
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
     * Builds and renders the menu view.
     *
     * @param Repository|null $repository The data repository to use for rendering.
     *
     * @throws \Throwable If rendering fails.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed The rendered view.
     */
    public function build(?Repository $repository = null)
    {
        return $this->render();
    }

    /**
     * Adds a badge to the menu item with a specific color.
     *
     * @param \Closure $badge The closure to generate the badge content.
     * @param Color    $color The color of the badge.
     *
     * @return $this The current Menu instance for method chaining.
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
     * Sets the URL (href attribute) for the menu item.
     *
     * @param string $url The URL to set.
     *
     * @return $this The current Menu instance for method chaining.
     */
    public function url(string $url): self
    {
        return $this->set('href', $url);
    }

    /**
     * Sets the permission(s) required to see the menu item.
     *
     * @param string|string[]|null $permission The required permission(s).
     *
     * @return $this The current Menu instance for method chaining.
     */
    public function permission(string|iterable|null $permission = null): self
    {
        if ($permission !== null) {
            $this->permit = false;
        }

        $user = Auth::user();

        if ($user === null) {
            return $this;
        }

        $this->permit = $user->hasAnyAccess($permission);

        return $this;
    }

    /**
     * Determines whether the menu item should be displayed based on permissions and visibility conditions.
     *
     * @return bool True if the menu item should be displayed, otherwise false.
     */
    public function isSee(): bool
    {
        return parent::isSee() && $this->permit;
    }

    /**
     * Sets the title for the menu item.
     *
     * @param string|null $title The title to set.
     *
     * @return $this The current Menu instance for method chaining.
     */
    public function title(?string $title = null): self
    {
        return $this->set('title', $title);
    }

    /**
     * Sets the slug for the menu item.
     *
     * @param string $slug The slug to set.
     *
     * @return $this The current Menu instance for method chaining.
     */
    public function slug(string $slug): self
    {
        return $this->set('slug', $slug);
    }

    /**
     * Sets the parent menu item for this menu item.
     *
     * @param string $parent The parent menu item slug or identifier.
     *
     * @return $this The current Menu instance for method chaining.
     */
    public function parent(string $parent): self
    {
        return $this->set('parent', $parent);
    }
}
