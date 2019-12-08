<?php
declare(strict_types=1);

namespace Orchid\Screen\Contents;

use Orchid\Screen\Layouts\Base;
use Orchid\Screen\Repository;

/**
 * Class User
 */
class Compendium extends Base
{
    /**
     * @var string
     */
    protected $template = 'platform::contents.compendium';

    /**
     * @var Repository
     */
    protected $query;

    /**
     * Key property for query
     *
     * @var string|array
     */
    protected $target;

    /**
     * Card constructor.
     *
     * @param string|array $target
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

        if (!is_array($this->target)) {
            $this->target = $repository->get($this->target);
        }

        return (string)$this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->render($this->target);
    }

    /**
     * @param array $list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(array $list)
    {
        return view($this->template, [
            'list' => $list,
        ]);
    }
}
