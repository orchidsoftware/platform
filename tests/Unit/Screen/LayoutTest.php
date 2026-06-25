<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen;

use Illuminate\Support\Str;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layout;
use Orchid\Screen\LayoutFactory;
use Orchid\Screen\Repository;
use Orchid\Tests\TestUnitCase;

class LayoutTest extends TestUnitCase
{
    public function testFindLayoutBySlugs(): void
    {
        $row = LayoutFactory::rows([
            Input::make('input'),
        ]);

        $layout = LayoutFactory::columns([
            LayoutFactory::tabs([
                'action 1' => LayoutFactory::accordion([$row]),
                'action 2' => $row,
            ]),
        ]);

        $find = $layout->findBySlug($row->getSlug());
        $this->assertEquals($row, $find);

        $find = $layout->findBySlug(Str::random());
        $this->assertNull($find);
    }

    public function testCanSeeLayout(): void
    {
        $layout = new class extends Layout
        {
            public function isSee(): bool
            {
                return $this->query->get('show');
            }

            public function build(Repository $repository)
            {
                $this->query = $repository;

                if (! $this->isSee()) {
                    return;
                }

                return 'display';
            }
        };

        $render = $layout->build(new Repository([
            'show' => false,
        ]));

        $this->assertNull($render);

        $render = $layout->build(new Repository([
            'show' => true,
        ]));

        $this->assertEquals('display', $render);
    }

    public function testGetSlug(): void
    {
        $layout = new class extends Layout
        {
            public function build(Repository $repository)
            {
                return null;
            }
        };

        $slug = $layout->getSlug();

        $this->assertIsString($slug);
        $this->assertNotEmpty($slug);
    }

    public function testFindByTypeWithSubclass(): void
    {
        $inner = new class extends Layout
        {
            public function build(Repository $repository)
            {
                return null;
            }
        };

        $outer = new class($inner) extends Layout
        {
            public function __construct(Layout $inner)
            {
                $this->layouts = [$inner];
            }

            public function build(Repository $repository)
            {
                return null;
            }
        };

        $found = $outer->findByType(Layout::class);
        $this->assertNotNull($found);

        $notFound = $outer->findByType('NonExistentClass');
        $this->assertNull($notFound);
    }

    public function testJsonSerialize(): void
    {
        $layout = new class extends Layout
        {
            protected $template = 'test-template';

            public function build(Repository $repository)
            {
                return null;
            }
        };

        $serialized = $layout->jsonSerialize();

        $this->assertIsArray($serialized);
        $this->assertArrayHasKey('template', $serialized);
        $this->assertEquals('test-template', $serialized['template']);
        $this->assertArrayNotHasKey('query', $serialized);
    }
}
