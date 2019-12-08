<?php

declare(strict_types=1);

namespace Orchid\Screen\Contents;

use Orchid\Screen\Layouts\Base;
use Orchid\Screen\Presenters\User as UserPresenter;
use Orchid\Screen\Repository;

/**
 * Class User.
 */
class User extends Base
{
    /**
     * @var string
     */
    protected $template = 'platform::contents.user';

    /**
     * @var Repository
     */
    protected $query;

    /**
     * Key property for query.
     *
     * @var string
     */
    protected $target;

    /**
     * Card constructor.
     *
     * @param string|UserPresenter $target
     */
    public function __construct($target)
    {
        $this->target = $target;
    }

    /**
     * @param Repository $repository
     *
     * @return string
     */
    public function build(Repository $repository)
    {
        $this->query = $repository;

        if (! is_a($this->target, UserPresenter::class)) {
            $this->target = $repository->get($this->target);
        }

        return (string) $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->render($this->target);
    }

    /**
     * @param UserPresenter $user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(UserPresenter $user)
    {
        return view($this->template, [
            'title'    => $user->title(),
            'subTitle' => $user->subTitle(),
            'image'    => $user->image(),
            'url'      => $user->url(),
        ]);
    }
}
