<?php

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

/**
 * Class Split.
 *
 * Represents a layout that divides the available space into two sections with a fixed width ratio.
 */
abstract class Split extends Layout
{
    /**
     * The name of the template file that will be used to render this layout.
     *
     * @var string
     */
    protected $template = 'platform::layouts.split';

    /**
     * An array of default variables that will be passed to the template.
     *
     * @var string[]
     */
    protected $variables = [
        'columnClass'    => ['col-md-6', 'col-md-6'],
        'reverseOnPhone' => false,
    ];

    /**
     * Split constructor.
     *
     * @param Layout[] $layouts The layouts that will be contained in this split layout.
     */
    public function __construct(array $layouts = [])
    {
        $this->layouts = $layouts;
    }

    /**
     * Builds the HTML representation of this layout.
     *
     * @param Repository $repository The repository instance.
     *
     * @return mixed The HTML representation of this layout.
     */
    public function build(Repository $repository)
    {
        return $this->buildAsDeep($repository);
    }

    /**
     * Sets the width ratio of the columns in this split layout.
     *
     * @param string $ratio The width ratio in the format 'X/Y'.
     *
     * @throws \InvalidArgumentException if the specified ratio is not valid.
     *
     * @return $this This instance of the Split class.
     */
    public function ratio(string $ratio): self
    {
        $allowedRatios = collect([
            '20/80' => ['col-md-2', 'col-md-10'],
            '30/70' => ['col-md-3', 'col-md-9'],
            '40/60' => ['col-md-4', 'col-md-8'],
            '50/50' => ['col-md-6', 'col-md-6'],
            '60/40' => ['col-md-8', 'col-md-4'],
            '70/30' => ['col-md-9', 'col-md-3'],
            '80/20' => ['col-md-10', 'col-md-2'],
        ]);

        throw_unless($allowedRatios->offsetExists($ratio), \InvalidArgumentException::class, sprintf(
            'Invalid ratio "%s". Allowed ratios: %s',
            $ratio,
            $allowedRatios->keys()->implode(', ')
        ));

        $this->variables['columnClass'] = $allowedRatios->get($ratio);

        return $this;
    }

    /**
     * Reverses the order of the columns in this split layout on mobile devices.
     *
     * @return $this This instance of the Split class.
     */
    public function reverseOnPhone(): self
    {
        $this->variables['reverseOnPhone'] = true;

        return $this;
    }
}
