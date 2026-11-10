<?php

namespace Orchid\Tests\Unit\Screen\Layouts;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Block;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Repository;
use Orchid\Tests\TestUnitCase;

class BlockTest extends TestUnitCase
{
    public function testRenderBlockTitle(): void
    {
        $layout = Block::make([])
            ->title('Profile Information');

        $html = $layout->build(new Repository)
            ->withErrors([])
            ->render();

        $this->assertStringContainsString('Profile Information', $html);
    }

    public function testRenderBlockDescription(): void
    {
        $layout = Block::make([])
            ->title('Profile Information')
            ->description("Update your account's profile information and email address.");

        $html = $layout->build(new Repository)
            ->withErrors([])
            ->render();

        $this->assertStringContainsString("Update your account's profile information and email address.", $html);
    }

    public function testRenderLayoutsBlock(): void
    {
        $repository = new Repository([
            'name' => 'Alexandr Chernyaev',
        ]);

        $row = Rows::make([
            Input::make('name'),
        ]);

        $layout = Block::make($row)
            ->title('Profile Information')
            ->description("Update your account's profile information and email address.");

        $html = $layout->build($repository)->withErrors([])->render();

        $this->assertStringContainsString('Alexandr Chernyaev', $html);
    }

    public function testRenderBlockCommand(): void
    {
        $layout = Block::make([])
            ->title('Profile Information')
            ->description("Update your account's profile information and email address.")
            ->commands(Button::make('Submit'));

        $html = $layout->build(new Repository)
            ->withErrors([])
            ->render();

        $this->assertStringContainsString('Submit', $html);
    }

    public function testRenderBlockManyCommand(): void
    {
        $layout = Block::make([])
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

    public function testRenderBlockViewDescription(): void
    {
        $view = view('exemplar::dummy.text');

        $layout = Block::make([])
            ->title('Profile Information')
            ->description($view);

        $html = $layout->build(new Repository)
            ->withErrors([])
            ->render();

        $this->assertStringContainsString($view->render(), $html);
    }
}
