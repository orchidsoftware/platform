<?php

namespace Orchid\Tests\Unit\Support;

use Orchid\Support\Locale;
use Orchid\Tests\TestUnitCase;

class LocaleTest extends TestUnitCase
{
    public function testCurrentDirReturnsRtlForRtlLanguages(): void
    {
        $rtlLanguages = ['ar', 'he', 'fa', 'ur', 'yi'];

        foreach ($rtlLanguages as $locale) {
            $this->assertEquals('rtl', Locale::currentDir($locale), "Failed asserting that $locale is RTL.");
        }
    }

    public function testCurrentDirReturnsLtrForNonRtlLanguages(): void
    {
        $ltrLanguages = ['en', 'fr', 'de', 'ru', 'zh'];

        foreach ($ltrLanguages as $locale) {
            $this->assertEquals('ltr', Locale::currentDir($locale), "Failed asserting that $locale is LTR.");
        }
    }

    public function testCurrentDirDefaultsToAppLocale(): void
    {
        app()->setLocale('ru');
        $this->assertEquals('ltr', Locale::currentDir());

        app()->setLocale('ar');
        $this->assertEquals('rtl', Locale::currentDir());

    }

    public function testCurrentDirHandlesInvalidLocale(): void
    {
        $this->assertEquals('ltr', Locale::currentDir('invalid-locale'));
    }
}
