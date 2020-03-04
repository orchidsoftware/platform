<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\View\Factory;
use Orchid\Screen\Builder;
use Orchid\Screen\Repository;
use Throwable;

/**
 * Class Rows.
 */
abstract class Rows extends Base
{
    /**
     * @var string
     */
    protected $template = 'platform::layouts.row';

    /**
     * @var Repository
     */
    protected $query;

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
            'form' => $form->generateForm(),
        ]);
    }

    /**
     * @return array
     */
    abstract protected function fields(): array;
}
