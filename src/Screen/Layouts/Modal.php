<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Orchid\Screen\Commander;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;
use Orchid\Support\Facades\Dashboard;

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
     * What screen method should be called
     * as a source for an asynchronous request.
     *
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $template = 'platform::layouts.modal';

    /**
     * Modal constructor.
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

    public function getSlug(): string
    {
        return $this->variables['key'];
    }

    /**
     * @return mixed
     */
    public function build(Repository $repository)
    {
        $this->variables = array_merge($this->variables, [
            'asyncEnable' => empty($this->method) ? 0 : 1,
            'asyncRoute'  => $this->asyncRoute(),
        ]);

        return $this->buildAsDeep($repository);
    }

    /**
     * Set the text button for apply action.
     */
    public function applyButton(string $text): self
    {
        $this->variables['apply'] = $text;

        return $this;
    }

    /**
     * Whether to disable the applied button or not.
     */
    public function withoutApplyButton(bool $withoutApplyButton = true): self
    {
        $this->variables['withoutApplyButton'] = $withoutApplyButton;

        return $this;
    }

    /**
     * Whether to disable the close button or not.
     */
    public function withoutCloseButton(bool $withoutCloseButton = true): self
    {
        $this->variables['withoutCloseButton'] = $withoutCloseButton;

        return $this;
    }

    /**
     * Set the text button for cancel action.
     */
    public function closeButton(string $text): self
    {
        $this->variables['close'] = $text;

        return $this;
    }

    /**
     * Set CSS class for size modal.
     */
    public function size(string $class): self
    {
        $this->variables['size'] = $class;

        return $this;
    }

    /**
     * Set CSS class for type modal.
     */
    public function type(string $class): self
    {
        $this->variables['type'] = $class;

        return $this;
    }

    /**
     * Set title for header modal.
     */
    public function title(string $title): self
    {
        $this->variables['title'] = $title;

        return $this;
    }

    /**
     * @return static
     */
    public function rawClick(bool $status = false): self
    {
        $this->variables['turbo'] = $status;

        return $this;
    }

    /**
     * @return $this
     */
    public function open(bool $status = true): self
    {
        $this->variables['open'] = $status;

        return $this;
    }

    /**
     * @return $this
     */
    public function method(string $method): self
    {
        $this->variables['method'] = url()->current().'/'.$method;

        return $this;
    }

    /**
     * @return $this
     */
    public function staticBackdrop(bool $status = true): self
    {
        $this->variables['staticBackdrop'] = $status;

        return $this;
    }

    /**
     * @param string $method
     *
     * @return $this
     */
    public function async(string $method): self
    {
        if (! Str::startsWith($method, 'async')) {
            $method = Str::start(Str::ucfirst($method), 'async');
        }

        $this->method = $method;

        return $this;
    }

    /**
     * Return URL for screen template requests from the browser.
     */
    protected function asyncRoute(): ?string
    {
        $screen = Dashboard::getCurrentScreen();

        if (! $screen) {
            return null;
        }

        return route('platform.async', [
            'screen'   => Crypt::encryptString(get_class($screen)),
            'method'   => $this->method,
            'template' => $this->getSlug(),
        ]);
    }
}
