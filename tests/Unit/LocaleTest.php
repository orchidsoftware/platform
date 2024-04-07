<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Illuminate\Support\Collection;
use Orchid\Platform\Orchid;
use Orchid\Tests\TestUnitCase;
use Symfony\Component\Finder\Finder;

class LocaleTest extends TestUnitCase
{
    public function testLoadTranslations(): void
    {
        $this->assertEquals(trans('Apply', [], 'ru'), 'Применить');
    }

    public function testTranslationsJsonValidation(): void
    {
        $this->getTranslationFiles()
            ->each(function (string $file) {
                $content = file_get_contents($file);

                $this->assertJson($content);
            });
    }

    public function testUsageAllTranslateString(): void
    {
        $this->getTranslationFiles()
            ->map(function (string $file) {
                $content = file_get_contents($file);

                $this->assertJson($content, "$file is not valid JSON");

                return array_keys(json_decode($content, true));
            })
            ->flatten()
            ->unique()
            ->each(function (string $translate) {
                $this->assertTrue(
                    $this->checkUsageTranslateStringInProject($translate),
                    "The string '$translate' is not used in the project!"
                );
            });
    }

    protected function getTranslationFiles(): Collection
    {
        $patternPath = Orchid::path('resources/lang').'/*.json';

        return collect(glob($patternPath));
    }

    /**
     * This solution checks for the presence of the
     * passed string in the project source codes.
     * She can only say that there is definitely no word.
     * Will give positive results on popular words that
     * can be used to name variables, properties, classes.
     */
    protected function checkUsageTranslateStringInProject(string $string): bool
    {
        return (new Finder())
            ->ignoreUnreadableDirs()
            ->followLinks()
            ->in([
                Orchid::path('src'),
                Orchid::path('stubs'),
                Orchid::path('routes'),
                Orchid::path('resources/js'),
                Orchid::path('resources/views'),
            ])
            ->contains($string)
            ->hasResults();
    }
}
