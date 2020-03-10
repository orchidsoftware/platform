<?php

declare(strict_types=1);

namespace Orchid\Platform;

use DOMDocument;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\Iterator\PathFilterIterator;
use Symfony\Component\Finder\SplFileInfo;

class Icon
{
    /**
     * @var Finder
     */
    private $finder;

    /**
     * @var array|string[]
     */
    private $directories;

    /**
     * Icon tag content.
     *
     * @var string
     */
    private $icon = '';

    /**
     * Tag attributes for XML.
     *
     * @var array
     */
    private $attributes = [
        'width'  => '1em',
        'height' => '1em',
        'class'  => 'icon',
        'role'   => 'img',
        'fill'   => 'currentColor',
    ];

    /**
     * Icon constructor.
     *
     * @param Finder   $finder
     * @param string[] $directories
     */
    public function __construct(Finder $finder, array $directories = [])
    {
        $this->finder = $finder;
        $this->directories = $directories;
    }

    /**
     * @param string   $name
     * @param string[] $attributes
     *
     * @return string
     */
    public function render(string $name, array $attributes = []): string
    {
        try {
            $this
                ->loadFile($name)
                ->setAttributes($attributes);
        } finally {
            return $this->icon;
        }
    }

    /**
     * @param string $name
     *
     * @return Icon
     */
    private function loadFile(string $name): self
    {
        $icons = $this->finder
            ->ignoreUnreadableDirs()
            ->followLinks()
            ->in($this->directories)
            ->files()
            ->name(Str::finish($name, '.svg'));

        /** @var PathFilterIterator $iterator */
        $iterator = tap($icons->getIterator())
            ->rewind();

        /** @var SplFileInfo|null $file */
        $file = collect($iterator)->first();

        $this->icon = $file !== null
            ? $file->getContents()
            : '';

        return $this;
    }

    /**
     * @param string[] $attributes
     *
     * @return Icon
     */
    private function setAttributes(array $attributes): self
    {
        $dom = new DOMDocument();
        $dom->loadXML($this->icon);

        /** @var \DOMElement $item */
        $item = collect($dom->getElementsByTagName('svg'))->first();

        $attributes = array_merge($this->attributes, $attributes);

        foreach ($attributes as $key => $value) {
            $item->setAttribute($key, $value);
        }

        $this->icon = $dom->saveHTML();

        return $this;
    }
}
