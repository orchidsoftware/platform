<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Orchid\Screen\Builder;
use Orchid\Screen\Field;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;
use Throwable;

/**
 * Class Rows.
 *
 * @phpstan-consistent-constructor
 */
class Rows extends Layout
{
    public function __construct(protected array $fields = []) {}

    public static function make(array $fields = []): static
    {
        return new static($fields);
    }

    /**
     * @var string
     */
    protected $template = 'orchid::layouts.row';

    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * @var Repository
     */
    protected $query;

    /**
     * @throws Throwable
     *
     * @return Factory|View|null
     */
    public function build(Repository $repository)
    {
        $this->query = $repository;

        if (! $this->isSee()) {
            return null;
        }

        $form = new Builder($this->fields(), $repository);

        return view($this->template, [
            'form'  => $form->generateForm(),
            'title' => $this->title,
        ]);
    }

    /**
     * Set the heading displayed above the form rows.
     */
    public function title(?string $title = null): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return iterable<Field>|iterable<string>
     */
    protected function fields(): iterable
    {
        return $this->fields;
    }
}
