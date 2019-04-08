<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Support\Arr;
use Orchid\Screen\Repository;

/**
 * Class Wrapper.
 */
abstract class Wrapper extends Base
{
    /**
     * @var string
     */
    public $template;

    /**
     * Wrapper constructor.
     *
     * @param string $template
     * @param Base[] $layouts
     */
    public function __construct(string $template, array $layouts = [])
    {
        $this->template = $template;
        $this->layouts = $layouts;
    }

    /**
     * @param Repository $repository
     *
     * @return mixed
     */
    public function build(Repository $repository)
    {
        $build = [];

        if (! $this->checkPermission($this, $repository)) {
            return;
        }

        foreach ($this->layouts as $key => $layouts) {
            $item = $this->buildChild(Arr::wrap($layouts), $key, $repository);

            if (! is_array($layouts)) {
                $item = reset($item)[0];
            }  else {
                $item = reset($item);
            }

            $build[$key] = $item;
        }

        $data = array_merge($repository->all(), $build);

        return view($this->template, $data);
    }
}
