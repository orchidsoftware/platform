<?php

namespace Orchid\Tests\Unit\Screen\Layouts;

use Orchid\Screen\Actions\Link;
use Orchid\Screen\Contracts\Cardable;
use Orchid\Screen\Layouts\Card;
use Orchid\Screen\Repository;
use Orchid\Support\Color;
use Orchid\Tests\TestUnitCase;

class CardTest extends TestUnitCase
{
    public function testQueryStringBind(): void
    {
        $repository = new Repository([
            'card' => $this->getCardClass(),
        ]);

        $layout = new Card('card', [
            Link::make('Website')
                ->href('https://orchid.software')
                ->rawClick(),
        ]);

        $html = $layout->build($repository);

        $this->assertStringContainsString('Title of a longer featured blog post', $html);
        $this->assertStringContainsString('href="https://orchid.software"', $html);
    }

    private function getCardClass(): Cardable
    {
        return new class implements Cardable
        {
            public function title(): string
            {
                return 'Title of a longer featured blog post';
            }

            public function description(): string
            {
                return 'This is a wider card with supporting text below as a natural lead-in to additional content. This content is a
                  little bit longer. This is a wider card with supporting text below as a natural lead-in to additional content. This
                  content is a little bit longer. This is a wider card with supporting text below as a natural lead-in to additional
                  content. This content is a little bit longer.';
            }

            /**
             * @return string
             */
            public function image(): ?string
            {
                return 'https://picsum.photos/600/300';
            }

            /**
             * @return mixed
             */
            public function color(): ?Color
            {
                return Color::INFO;
            }
        };
    }

    public function testQueryParams(): void
    {
        $layout = new Card($this->getCardClass(), [
            Link::make('Website')
                ->href('https://orchid.software')
                ->rawClick(),
        ]);

        $html = $layout->build(new Repository());

        $this->assertStringContainsString('Title of a longer featured blog post', $html);
        $this->assertStringContainsString('href="https://orchid.software"', $html);
    }
}
