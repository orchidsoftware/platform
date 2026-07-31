<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Cells;

use Orchid\Screen\Components\Cells\Text;
use Orchid\Screen\Repository;
use Orchid\Tests\TestUnitCase;

class TextTest extends TestUnitCase
{
    public function testRenderText(): void
    {
        $repository = new Repository([
            'content' => 'This is a sample text for testing purposes.',
        ]);

        $component = new Text($repository, text: 'content');

        $this->assertStringContainsString('This is a sample text for testing purposes.', $component->render());
    }

    public function testRenderTextWithTitle(): void
    {
        $repository = new Repository([
            'title'   => 'Sample Title',
            'content' => 'This is a sample text for testing purposes.',
        ]);

        $component = new Text($repository, title: 'title', text: 'content');

        $this->assertStringContainsString('Sample Title', $component->render());
        $this->assertStringContainsString('This is a sample text for testing purposes.', $component->render());
    }

    public function testRenderTextWithClampClass(): void
    {
        $repository = new Repository([
            'content' => 'This is a sample text for testing purposes.',
        ]);

        $component = new Text($repository, text: 'content', clamp: 3);

        $this->assertStringContainsString('line-clamp-3', $component->render());
    }

    public function testRenderTextWordsLimit(): void
    {
        $repository = new Repository([
            'content' => 'word1 word2 word3 word4 word5 word6 word7 word8 word9 word10',
        ]);

        $component = new Text($repository, text: 'content', words: 3);

        $this->assertStringContainsString('word1 word2 word3', $component->render());
        $this->assertStringNotContainsString('word4', $component->render());
    }

    public function testRenderTextNoClamp(): void
    {
        $repository = new Repository([
            'content' => 'Simple text.',
        ]);

        $component = new Text($repository, text: 'content', clamp: null);

        $this->assertStringContainsString('text-balance line-clamp', $component->render());
        $this->assertStringNotContainsString('line-clamp-', $component->render());
    }

    public function testRenderTextWithoutTitle(): void
    {
        $repository = new Repository([
            'content' => 'Just content.',
        ]);

        $component = new Text($repository, text: 'content');

        $this->assertStringContainsString('Just content.', $component->render());
        $this->assertStringNotContainsString('<strong', $component->render());
    }
}
