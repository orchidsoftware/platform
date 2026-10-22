<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Layouts;

use DOMDocument;
use DOMXPath;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\MessageBag;
use Orchid\Filters\Filter;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\LayoutFactory;
use Orchid\Screen\Layouts\Selection;
use Orchid\Screen\Repository;
use Orchid\Tests\TestUnitCase;

class TemplateSimplificationTest extends TestUnitCase
{
    public function testValidationMessagesRemainOrderedAndEscaped(): void
    {
        $messages = new MessageBag([
            'name'  => ['Name is required.', 'Name is too short.'],
            'email' => ['Invalid <script>alert(1)</script> address.'],
        ]);
        $html = view('orchid::partials.alert')->withErrors($messages)->render();
        $xpath = $this->xpath($html);

        $this->assertSame($messages->all(), array_map(
            fn ($item) => $item->textContent,
            iterator_to_array($xpath->query('//li')),
        ));
        $this->assertCount(0, $xpath->query('//script'));
        $this->assertStringContainsString('role="alert"', $html);
        $this->assertStringNotContainsString('alert-danger', view('orchid::partials.alert')->withErrors([])->render());
    }

    public function testFlashFeedbackKeepsItsAnnouncementPriority(): void
    {
        foreach (['info' => 'polite', 'success' => 'polite', 'warning' => 'assertive', 'danger' => 'assertive'] as $level => $priority) {
            session()->put('flash_notification.message', 'Saved');
            session()->put('flash_notification.level', $level);
            $html = view('orchid::partials.alert')->withErrors([])->render();

            $this->assertStringContainsString('aria-live="'.$priority.'"', $html);
            $this->assertStringContainsString('role="'.($priority === 'polite' ? 'status' : 'alert').'"', $html);
        }
    }

    public function testMetricValuesRoundingAndSignsRemainIntact(): void
    {
        foreach ([[12.345, '12.35'], [12.3, '12.3'], [12, '12'], [-2.5, '-2.5'], [0.001, '0']] as [$diff, $expected]) {
            $metric = ['value' => 'Existing value', 'diff' => $diff];
            $repository = new Repository(['orders' => $metric]);
            $html = LayoutFactory::metrics(['Orders' => 'orders'])->build($repository)->render();
            $change = $this->xpath($html)->query('//p/small')->item(0);

            $this->assertNotNull($change);
            $this->assertSame($expected, trim(str_replace(["\u{00A0}", '%'], '', $change->textContent)));
            $this->assertStringContainsString($diff < 0 ? 'text-danger' : 'text-success', $change->getAttribute('class'));
            $this->assertStringContainsString('Existing value', $html);
            $this->assertSame($metric, $repository->getContent('orders'));
        }

        $html = LayoutFactory::metrics(['Orders' => 'orders'])->build(new Repository([
            'orders' => ['value' => 0, 'diff' => -0.001],
        ]))->render();
        $this->assertStringContainsString('text-danger', $this->xpath($html)->query('//p/small')->item(0)->getAttribute('class'));
    }

    public function testMetricsWithoutAChangeKeepScalarAndArrayValues(): void
    {
        foreach ([42, 'Existing value', ['value' => 42], ['value' => 42, 'diff' => null], ['value' => 42, 'diff' => 0]] as $metric) {
            $html = LayoutFactory::metrics(['Orders' => 'orders'])->build(new Repository(['orders' => $metric]))->render();
            $this->assertCount(0, $this->xpath($html)->query('//p/small'));
            $this->assertStringContainsString(is_array($metric) ? '42' : (string) $metric, $html);
        }
    }

    public function testLineResetKeepsTheExistingControllerWithoutPostingTheScreen(): void
    {
        $filter = new class extends Filter
        {
            public $parameters = ['name'];

            public function run(Builder $builder): Builder
            {
                return $builder;
            }

            public function display(): iterable
            {
                return [Input::make('name')];
            }
        };
        $layout = LayoutFactory::selection([$filter]);
        $layout->template = Selection::TEMPLATE_LINE;
        $xpath = $this->xpath('<form method="post">'.$layout->build(new Repository)->render().'</form>');
        $reset = $xpath->query('//button[@data-action="filter#clear"]')->item(0);

        $this->assertNotNull($reset);
        $this->assertSame('button', $reset->getAttribute('type'));
        $this->assertSame('filters', $xpath->query('//button[@type="submit"]')->item(0)->getAttribute('form'));
    }

    private function xpath(string $html): DOMXPath
    {
        $document = new DOMDocument;
        @$document->loadHTML($html);

        return new DOMXPath($document);
    }
}
