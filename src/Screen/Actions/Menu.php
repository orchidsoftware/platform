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
        'sort'           => 0,
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

                $this
                    ->set('data-bs-toggle', 'collapse')
                    ->set('href', '#menu-' . Str::slug($this->get('name')));
            })
            ->addBeforeRender(function () {
                $href = $this->get('href');
                $active = $this->get('active', [
                    $href,
                    $href . '?*',
                    $href . '/*',
                ]);

                $this->set('active', $active);
            });
    }

    /**
     * @param Actionable[] $list
     *
     * @return DropDown
     */
    public function list(array $list): self
    {
        $subMenu = collect($list)->sort(function (Menu $menu){
            return $menu->get('sort', 0);
        });

        return $this->set('list', $subMenu);
    }

    /**
     * @param Repository|null $repository
     *
     * @throws \Throwable
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     *
     */
    public function build(Repository $repository = null)
    {
        $this->set('source', $repository);

        return $this->render();
    }

    /**
     * @param \Closure   $badge
     * @param Color|null $color
     *
     * @return $this
     */
    public function badge(\Closure $badge, Color $color = null): self
    {
        $this->set('badge', [
            'class' => $color ?? Color::PRIMARY(),
            'data'  => $badge,
        ]);

        return $this;
    }

    /**
     * @param string $url
     *
     * @return Menu|\Orchid\Screen\Field
     */
    public function url(string $url)
    {
        return $this->set('href', $url);
    }

    /**
     * @param string $permission
     *
     * @return Menu
     */
    public function permission(?string $permission)
    {
        if ($permission === null) {
            return $this;
        }

        $user = Auth::user();

        if ($user === null) {
            return $this;
        }

        $this->permit = $user->hasAccess($permission);

        return $this;
    }

    /**
     * @return bool
     */
    public function isSee(): bool
    {
        return parent::isSee() && $this->permit;
    }

    /**
     * @param string|null $title
     *
     * @return Link
     */
    public function title(?string $title = null): Link
    {
        return $this->set('title', $title);
    }
}
