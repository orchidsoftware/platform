<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Repository;

/**
 * Class Modals.
 */
abstract class Modals extends Base
{
    public const SIZE_LG = 'modal-lg';
    public const SIZE_SM = 'modal-sm';

    public const TYPE_CENTER = '';
    public const TYPE_RIGHT = 'slide-right';

    /**
     * @var string
     */
    public $template = 'platform::layouts.modals';

    /**
     * Modals constructor.
     *
     * @param array $layouts
     */
    public function __construct(array $layouts = [])
    {
        $this->variables = [
            'apply' => __('Apply'),
            'close' => __('Close'),
            'size'  => '',
            'type'  => self::TYPE_CENTER,
        ];

        parent::__construct($layouts);
    }

    /**
     * @param Repository $repository
     *
     * @return mixed
     */
    public function build(Repository $repository)
    {
        return $this->buildAsDeep($repository);
    }

    /**
     * Set text button for apply action.
     *
     * @param string $text
     *
     * @return Modals
     */
    public function applyButton(string $text): self
    {
        $this->variables['apply'] = $text;

        return $this;
    }

    /**
     * Set text button for cancel action.
     *
     * @param string $text
     *
     * @return Modals
     */
    public function closeButton(string $text): self
    {
        $this->variables['close'] = $text;

        return $this;
    }

    /**
     * Set CSS class for size modal.
     *
     * @param string $class
     *
     * @return Modals
     */
    public function size(string $class): self
    {
        $this->variables['size'] = $class;

        return $this;
    }

    /**
     * Set CSS class for type modal.
     *
     * @param string $class
     *
     * @return Modals
     */
    public function type(string $class): self
    {
        $this->variables['type'] = $class;

        return $this;
    }
}
