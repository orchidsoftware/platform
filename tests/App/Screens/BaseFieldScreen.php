<?php

namespace Orchid\Tests\App\Screens;

use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

abstract class BaseFieldScreen extends Screen
{
    /**
     * @return array
     */
    abstract public function fields(): array;

    /**
     * @return array
     */
    public function query(): array
    {
        return [];
    }

    /**
     * Display header name.
     *
     * @return string|null
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

    /**
     * @param Request $request
     *
     * @return string
     */
    public function submit(Request $request): string
    {
        return $request->collect()->except(['_token'])->toJson(JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
