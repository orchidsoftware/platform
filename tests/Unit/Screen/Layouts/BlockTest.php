<?php

namespace Orchid\Tests\Unit\Screen\Layouts;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\LayoutFactory;
use Orchid\Screen\Repository;
use Orchid\Tests\TestUnitCase;

class BlockTest extends TestUnitCase
{
    public function testRenderBlockTitle(): void
    {
        $layout = LayoutFactory::block([])
            ->title('Profile Information');

        $html = $layout->build(new Repository())
            ->withErrors([])
            ->render();

        $this->assertStringContainsString('Profile Information', $html);
    }

    public function testRenderBlockDescription(): void
    {
        $layout = LayoutFactory::block([])
            ->title('Profile Information')
            ->description("Update your account's profile information and email address.");

        $html = $layout->build(new Repository())
            ->withErrors([])
            ->render();

        $this->assertStringContainsString("Update your account's profile information and email address.", $html);
    }

    public function testRenderLayoutsBlock(): void
    {
        $repository = new Repository([
            'name' => 'Alexandr Chernyaev',
        ]);

        $row = LayoutFactory::rows([
            Input::make('name'),
        ]);

        $layout = LayoutFactory::block($row)
            ->title('Profile Information')
            ->description("Update your account's profile information and email address.");

        $html = $layout->build($repository)->withErrors([])->render();

        $this->assertStringContainsString('Alexandr Chernyaev', $html);
    }

    public function testRenderBlockCommand(): void
    {
        $repository = new Repository();

        $layout = LayoutFactory::block([])
            ->title('Profile Information')
            ->description("Update your account's profile information and email address.")
            ->commands(Button::make('Submit'));

        $html = $layout->build($repository)->withErrors([])->render();

        $this->assertStringContainsString('Submit', $html);
    }

    public function testRenderBlockManyCommand(): void
    {
        $repository = new Repository();

        $layout = LayoutFactory::block([])
            ->title('Profile Information')
            ->description("Update your account's profile information and email address.")
            ->commands([
                Button::make('Submit'),
                Link::make('Link to site'),
            ]);

        $html = $layout->build($repository)->withErrors([])->render();

        $this->assertStringContainsString('Submit', $html);
        $this->assertStringContainsString('Link to site', $html);
    }
}
