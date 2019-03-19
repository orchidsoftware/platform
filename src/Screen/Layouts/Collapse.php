<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Builder;
use Orchid\Screen\Repository;

/**
 * Class Collapse.
 */
abstract class Collapse extends Base
{
    /**
     * @var string
     */
    public $template = 'platform::container.layouts.collapse';

    /**
     * @var Repository
     */
    public $query;

    /**
     * @var string
     */
    private $label = 'Options';

    /**
     * @param \Orchid\Screen\Repository $query
     *
     * @throws \Throwable
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function build(Repository $query)
    {
        $this->query = $query;
        $form = new Builder($this->fields(), $query);

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
