<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Layouts;

use Orchid\Tests\TestUnitCase;

class AccordionDisclosureStateTest extends TestUnitCase
{
    public function testHeadingChevronStateMatchesInitialDisclosureState(): void
    {
        $html = view('orchid::layouts.accordion', [
            'templateSlug' => 'preferences',
            'manyForms'    => [
                'General' => ['General content'],
                'Advanced' => ['Advanced content'],
            ],
            'open'     => ['General'],
            'stayOpen' => false,
        ])->render();

        self::assertMatchesRegularExpression(
            '/class="accordion-heading[^"]*"[^>]+aria-expanded="true"/s',
            $html,
        );
        self::assertMatchesRegularExpression(
            '/class="accordion-heading[^"]*collapsed[^"]*"[^>]+aria-expanded="false"/s',
            $html,
        );
    }

    public function testDisclosureTargetsAreScopedToTheirAccordion(): void
    {
        $html = '';

        foreach (['preferences', 'permissions'] as $templateSlug) {
            $html .= view('orchid::layouts.accordion', [
                'templateSlug' => $templateSlug,
                'manyForms'    => ['General' => ['Content']],
                'open'         => [],
                'stayOpen'     => false,
            ])->render();
        }

        foreach (['preferences', 'permissions'] as $templateSlug) {
            $collapseId = 'collapse-'.$templateSlug.'-general';
            $headingId = 'heading-'.$templateSlug.'-general';

            self::assertSame(1, substr_count($html, 'id="'.$collapseId.'"'));
            self::assertSame(1, substr_count($html, 'id="'.$headingId.'"'));
            self::assertStringContainsString('data-bs-target="#'.$collapseId.'"', $html);
            self::assertStringContainsString('aria-controls="'.$collapseId.'"', $html);
            self::assertStringContainsString('aria-labelledby="'.$headingId.'"', $html);
        }
    }
}
