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
    public function test_render_block_title(): void
    {
        $layout = LayoutFactory::block([])
            ->title('Profile Information');

        $html = $layout->build(new Repository)
            ->withErrors([])
            ->render();

        $this->assertStringContainsString('Profile Information', $html);
    }

    public function test_render_block_description(): void
    {
        $layout = LayoutFactory::block([])
            ->title('Profile Information')
            ->description("Update your account's profile information and email address.");

        $html = $layout->build(new Repository)
            ->withErrors([])
            ->render();

        $this->assertStringContainsString("Update your account's profile information and email address.", $html);
    }

    public function test_render_layouts_block(): void
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

    public function test_render_block_command(): void
    {
        $layout = LayoutFactory::block([])
            ->title('Profile Information')
            ->description("Update your account's profile information and email address.")
            ->commands(Button::make('Submit'));

        $html = $layout->build(new Repository)
            ->withErrors([])
            ->render();

        $this->assertStringContainsString('Submit', $html);
    }

    public function test_render_block_many_command(): void
    {
        $layout = LayoutFactory::block([])
            ->title('Profile Information')
            ->description("Update your account's profile information and email address.")
            ->commands([
                Button::make('Submit'),
                Link::make('Link to site'),
            ]);

        $html = $layout->build(new Repository)
            ->withErrors([])
            ->render();

        $this->assertStringContainsString('Submit', $html);
        $this->assertStringContainsString('Link to site', $html);
    }

    public function test_render_block_view_description(): void
    {
        $view = view('exemplar::dummy.text');

        $layout = LayoutFactory::block([])
            ->title('Profile Information')
            ->description($view);

        $html = $layout->build(new Repository)
            ->withErrors([])
            ->render();

        $this->assertStringContainsString($view->render(), $html);
    }
}
