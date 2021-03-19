<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Commander;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

/**
 * Class Modal.
 */
class Modal extends Layout
{
    use Commander;

    public const SIZE_LG = 'modal-lg';
    public const SIZE_SM = 'modal-sm';

    public const TYPE_CENTER = '';
    public const TYPE_RIGHT = 'slide-right';

    /**
     * The modal window variation key,
     * for example, on the right, in the center.
     *
     * @var string
     */
    protected $type = self::TYPE_CENTER;

    /**
     * The size of the modal window,
     * for example, large or small.
     *
     * @var string
     */
    protected $size;

    /**
     * @var string
     */
    protected $template = 'platform::layouts.modal';

    /**
     * Modal constructor.
     *
     * @param string $key
     * @param array  $layouts
     */
    public function __construct(string $key, array $layouts = [])
    {
        $this->variables = [
            'apply'              => __('Apply'),
            'close'              => __('Close'),
            'size'               => '',
            'type'               => self::TYPE_CENTER,
            'key'                => $key,
            'title'              => $key,
            'turbo'              => true,
            'commandBar'         => [],
            'withoutApplyButton' => false,
            'withoutCloseButton' => false,
            'open'               => false,
            'method'             => null,
            'staticBackdrop'     => false,
        ];

        $this->layouts = $layouts;
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
     * @return Modal
     */
    public function applyButton(string $text): self
    {
        $this->variables['apply'] = $text;

        return $this;
    }

    /**
     * Whether to disable the apply button or not.
     *
     * @param bool $withoutApplyButton
     *
     * @return Modal
     */
    public function withoutApplyButton(bool $withoutApplyButton = true): self
    {
        $this->variables['withoutApplyButton'] = $withoutApplyButton;

        return $this;
    }

    /**
     * Whether to disable the close button or not.
     *
     * @param bool $withoutCloseButton
     *
     * @return Modal
     */
    public function withoutCloseButton(bool $withoutCloseButton = true): self
    {
        $this->variables['withoutCloseButton'] = $withoutCloseButton;

        return $this;
    }

    /**
     * Set text button for cancel action.
     *
     * @param string $text
     *
     * @return Modal
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
     * @return Modal
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
     * @return Modal
     */
    public function type(string $class): self
    {
        $this->variables['type'] = $class;

        return $this;
    }

    /**
     * Set title for header modal.
     *
     * @param string $title
     *
     * @return Modal
     */
    public function title(string $title): self
    {
        $this->variables['title'] = $title;

        return $this;
    }

    /**
     * @param bool $status
     *
     * @return static
     */
    public function rawClick(bool $status = false): self
    {
        $this->variables['turbo'] = $status;

        return $this;
    }

    /**
     * @param bool $status
     *
     * @return $this
     */
    public function open(bool $status = true): self
    {
        $this->variables['open'] = $status;

        return $this;
    }

    /**
     * @param string $method
     *
     * @return $this
     */
    public function method(string $method): self
    {
        $this->variables['method'] = $method;

        return $this;
    }

    /**
     * @param bool $status
     *
     * @return $this
     */
    public function staticBackdrop(bool $status = true): self
    {
        $this->variables['staticBackdrop'] = $status;

        return $this;
    }
}
