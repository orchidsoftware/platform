<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Support;

use Orchid\Support\Blade;
use Orchid\Tests\TestUnitCase;

class EmptyStateTest extends TestUnitCase
{
    private const EMPTY_STATE_COPY = [
        'No items yet',
        'New items will appear here.',
        'No matches',
        'Try changing or clearing the filters.',
        'Clear filters',
        'No results',
        'Try a different search.',
        'No new notifications.',
    ];

    public function testRendersOptionalContent(): void
    {
        $html = Blade::renderComponent('orchid-empty-state', [
            'icon'        => 'bs.inbox',
            'title'       => 'Nothing here yet',
            'description' => 'Create the first item to get started.',
        ]);

        $this->assertStringContainsString('class="empty-state ', $html);
        $this->assertStringContainsString('Nothing here yet', $html);
        $this->assertStringContainsString('Create the first item to get started.', $html);
        $this->assertStringContainsString('<p class="h5 ', $html);
        $this->assertStringContainsString('<svg', $html);
    }

    public function testRendersWithoutOptionalContent(): void
    {
        $html = Blade::renderComponent('orchid-empty-state', []);

        $this->assertStringContainsString('class="empty-state ', $html);
        $this->assertStringNotContainsString('<p', $html);
        $this->assertStringNotContainsString('<svg', $html);
    }

    public function testEscapesCopyAndOmitsEmptyElements(): void
    {
        $html = Blade::renderComponent('orchid-empty-state', [
            'title'       => '<script>alert("title")</script>',
            'description' => '',
        ]);

        $this->assertStringContainsString('&lt;script&gt;alert(&quot;title&quot;)&lt;/script&gt;', $html);
        $this->assertStringNotContainsString('<script>', $html);
        $this->assertStringNotContainsString('class="text-muted mb-0"', $html);
    }

    public function testEverySupportedLocaleHasConciseCopy(): void
    {
        $languagePath = dirname(__DIR__, 3).'/resources/lang';
        $jsonLocales = glob($languagePath.'/*.json');

        foreach ($jsonLocales as $jsonLocale) {
            $locale = pathinfo($jsonLocale, PATHINFO_FILENAME);
            $translations = json_decode((string) file_get_contents($jsonLocale), true, flags: JSON_THROW_ON_ERROR);

            foreach (self::EMPTY_STATE_COPY as $source) {
                if ($locale === 'en') {
                    $this->assertSame($source, __($source, locale: $locale));

                    continue;
                }

                $this->assertArrayHasKey($source, $translations, "Missing [{$source}] copy for [{$locale}].");
                $this->assertNotSame('', trim($translations[$source]), "Empty [{$source}] copy for [{$locale}].");
            }
        }
    }

    public function testCopyUsesCurrentLocale(): void
    {
        app()->setLocale('ru');

        $this->assertSame('Результатов нет', __('No results'));
        $this->assertSame('Новых уведомлений нет.', __('No new notifications.'));
    }
}
