<?php

declare(strict_types=1);

namespace Orchid\Screen\Contents;

use Orchid\Screen\Action;
use Orchid\Screen\Contracts\ActionContract;
use Orchid\Screen\Layouts\Base;
use Orchid\Screen\Repository;

/**
 * Class CardContent.
 */
class Card extends Base
{
    /**
     * @var string
     */
    protected $template = 'platform::contents.card';

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
     * @var array|Action[]
     */
    protected $commandBar;

    /**
     * Card constructor.
     *
     * @param string   $target
     * @param Action[] $commandBar
     */
    public function __construct(string $target, array $commandBar = [])
    {
        $this->target = $target;
        $this->commandBar = $commandBar;
    }

    /**
     * @param Repository $repository
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function build(Repository $repository)
    {
        $this->query = $repository;

        $card = $repository->get($this->target);

        return view($this->template, [
            'title'        => $card->title(),
            'descriptions' => $card->descriptions(),
            'image'        => $card->image(),
            'commandBar'   => $this->buildCommandBar(),
            'status'       => $card->status(),
            'users'        => [], //$card->buildUserBar(),
        ]);
    }

    /**
     * @return array
     */
    private function buildCommandBar(): array
    {
        return collect($this->commandBar)
            ->map(function (ActionContract $command) {
                return $command->build($this->query);
            })->all();
    }
}
