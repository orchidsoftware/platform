<?php

namespace Orchid\Tests\App\Screens;

use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

abstract class BaseFieldScreen extends Screen
{
    abstract public function fields(): array;

    public function query(): array
    {
        return [];
    }

    /**
     * Display header name.
     */
    public function name(): ?string
    {
        return 'Base Field Screen Test';
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Submit')
                ->rawClick()
                ->method('submit'),
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            Layout::rows($this->fields()),
        ];
    }

    public function submit(Request $request): string
    {
        return $request->collect()->except(['_token','_state'])->toJson(JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
