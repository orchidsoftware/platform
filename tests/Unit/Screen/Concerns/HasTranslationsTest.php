<?php

namespace Orchid\Tests\Unit\Screen\Concerns;

use Orchid\Screen\Concerns\HasTranslations;
use Orchid\Tests\TestUnitCase;

class HasTranslationsTest extends TestUnitCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->field = new class
        {
            use HasTranslations;

            public function getTranslations()
            {
                return $this->translations;
            }
        };
    }

    public function testCanMarkAttributeAsTranslatable(): void
    {
        $this->field->translatable('title');

        $this->assertTrue($this->field->shouldTranslate('title'));
    }

    public function testCanMarkMultipleAttributesAsTranslatable(): void
    {
        $this->field->translatable(['title', 'description']);

        $this->assertTrue($this->field->shouldTranslate('title'));
        $this->assertTrue($this->field->shouldTranslate('description'));
    }

    public function testIgnoresDuplicateTranslatableAttributes(): void
    {
        $this->field->translatable(['title', 'title']);

        $this->assertCount(1, $this->field->getTranslations());
        $this->assertTrue($this->field->shouldTranslate('title'));
    }

    public function testCanExcludeSingleAttributeFromTranslation(): void
    {
        $this->field->translatable(['title', 'description']);
        $this->field->withoutTranslation('title');

        $this->assertFalse($this->field->shouldTranslate('title'));
        $this->assertTrue($this->field->shouldTranslate('description'));
    }

    public function testCanExcludeMultipleAttributesFromTranslation(): void
    {
        $this->field->translatable(['title', 'description', 'summary']);
        $this->field->withoutTranslation(['title', 'summary']);

        $this->assertFalse($this->field->shouldTranslate('title'));
        $this->assertFalse($this->field->shouldTranslate('summary'));
        $this->assertTrue($this->field->shouldTranslate('description'));
    }

    public function testCanExcludeNonExistingAttribute(): void
    {
        $this->field->translatable(['title', 'description']);
        $this->field->withoutTranslation('summary');

        $this->assertTrue($this->field->shouldTranslate('title'));
        $this->assertTrue($this->field->shouldTranslate('description'));

        $this->assertFalse($this->field->shouldTranslate('summary'));
        $this->assertCount(2, $this->field->getTranslations());
    }
}
