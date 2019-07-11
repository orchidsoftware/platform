<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Throwable;
use Orchid\Screen\Builder;
use Orchid\Screen\Repository;
use Illuminate\Contracts\View\Factory;

/**
 * Class Collapse.
 */
abstract class Collapse extends Base
{
    /**
     * @var string
     */
    public $template = 'platform::layouts.collapse';

    /**
     * @var Repository
     */
    public $query;

    /**
     * @var string
     */
    private $label = 'Options';

    /**
     * Base constructor.
     *
     * @param Base[] $layouts
     */
    public function __construct(array $layouts = [])
    {
        $this->layouts = $layouts;
    }

    /**
     * @param Repository $repository
     *
     * @throws Throwable
     *
     * @return Factory|\Illuminate\View\View
     */
    public function build(Repository $repository)
    {
        if (! $this->checkPermission($this, $repository)) {
            return;
        }

        $this->query = $repository;
        $form = new Builder($this->fields(), $repository);

        return view($this->template, [
            'form'  => $form->generateForm(),
            'slug'  => $this->getSlug(),
            'label' => $this->label,
        ]);
    }

    /**
     * @param string $label
     *
     * @return Collapse
     */
    public function label(string $label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return array
     */
    abstract public function fields(): array;
}
