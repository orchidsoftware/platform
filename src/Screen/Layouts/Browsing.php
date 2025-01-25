<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\View\View;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

class Browsing extends Layout
{
    /**
     * @var string
     */
    protected string $template = 'platform::layouts.browsing';

    /**
     * @var array
     */
    protected array $variables = [
        'allow'          => null,
        'loading'        => 'lazy',
        'csp'            => null,
        'name'           => null,
        'referrerpolicy' => null,
        'sandbox'        => null,
        'src'            => null,
        'srcdoc'         => null,
        'width'          => '100%',
    ];

    /**
     * Browsing constructor.
     */
    public function __construct(string $src)
    {
        $this->src($src);
    }

    /**
     * @param Repository $repository
     * @return View|null
     */
    public function build(Repository $repository): ?View
    {
        $this->query = $repository;

        if (! $this->isSee()) {
            return null;
        }

        return view($this->template, [
            'attributes' => array_filter($this->variables),
        ]);
    }

    /**
     * Specifies a feature policy for the <iframe>.
     * The policy defines what features are available to the <iframe> based on the origin of the request
     * (e.g., access to the microphone, camera, battery, web-share API, etc.).
     */
    public function allow(?string $allow = null): self
    {
        $this->variables['allow'] = $allow;

        return $this;
    }

    /**
     * Indicates how the browser should load the iframe
     *
     *
     * @return $this
     */
    public function loading(?string $loading = null): self
    {
        $this->variables['loading'] = $loading;

        return $this;
    }

    /**
     * A Content Security Policy enforced for the embedded resource.
     *
     * @return $this
     */
    public function csp(?string $csp = null): self
    {
        $this->variables['csp'] = $csp;

        return $this;
    }

    /**
     * A targetable name for the embedded browsing context.
     *
     * @return $this
     */
    public function name(?string $name = null): self
    {
        $this->variables['name'] = $name;

        return $this;
    }

    /**
     * Indicates which referrer to send when fetching the frame's resource.
     *
     * @return $this
     */
    public function referrerpolicy(?string $referrerpolicy = null): self
    {
        $this->variables['referrerpolicy'] = $referrerpolicy;

        return $this;
    }

    /**
     * Applies extra restrictions to the content in the frame.
     * The value of the attribute can either be empty to apply all restrictions.
     *
     * @return $this
     */
    public function sandbox(?string $sandbox = null): self
    {
        $this->variables['sandbox'] = $sandbox;

        return $this;
    }

    /**
     * Applies extra restrictions to the content in the frame.
     * The value of the attribute can either be empty to apply all restrictions.
     * 
     * @return $this
     */
    public function src(string $src): self
    {
        $this->variables['src'] = $src;

        return $this;
    }

    /**
     * Inline HTML to embed, overriding the src attribute.
     *
     * @return $this
     */
    public function srcdoc(string $srcdoc): self
    {
        $this->variables['srcdoc'] = $srcdoc;

        return $this;
    }
}
