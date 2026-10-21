<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Fields;

use Orchid\Screen\Builder;
use Orchid\Screen\Fields\Attach;
use Orchid\Screen\Fields\DateRange;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\RadioButtons;
use Orchid\Screen\Fields\Repeater;

class RepeaterBrowserFixture
{
    public static function render(): string
    {
        $fields = [
            Repeater::make('periods')->cloneableRows()->reorderableRows()->fields([
                DateRange::make('window')->format('Y-m-d')->disableMobile(),
            ])->value([['window' => ['start' => '2026-10-10', 'end' => '2026-10-12']]]),
            Repeater::make('sparse')->fields([Input::make('name')]),
            Repeater::make('choices')->cloneableRows()->reorderableRows()->fields([
                RadioButtons::make('status')->options([
                    'draft' => 'Draft', 'published' => 'Published', 'archived' => 'Archived',
                ]),
            ])->value([['status' => 'draft'], ['status' => 'published']]),
            Repeater::make('articles')->cloneableRows()->reorderableRows()->fields([
                Quill::make('body')->toolbar(['text']),
            ])->value([['body' => '<p>Original</p>']]),
            Repeater::make('uploads')->cloneableRows()->reorderableRows()->fields([
                RepeaterBrowserAttach::make('files')->multiple()->uploadUrl('/repeater/submit')->sortUrl('/repeater/submit'),
            ])->emptyRows(1),
            Repeater::make('locked_uploads')->readonly()->fields([
                RepeaterBrowserAttach::make('files')->multiple()->uploadUrl('/repeater/upload')->sortUrl('/repeater/submit'),
            ])->value([['files' => [
                ['id' => 51, 'url' => '/favicon.ico', 'original_name' => 'locked.png', 'mime' => 'image/png'],
            ]]]),
            Repeater::make('external_uploads')->readonly()->fields([
                RepeaterBrowserAttach::make('files')->multiple()->set('form', 'other'),
                RepeaterBrowserAttach::make('empty')->set('form', 'other'),
            ])->value([['files' => [
                ['id' => 61, 'url' => '/favicon.ico', 'original_name' => 'external.png', 'mime' => 'image/png'],
            ]]]),
            Repeater::make('locked')->readonly()->fields([
                Quill::make('body')->toolbar(['text']),
                Input::make('excluded')->disabled(),
                Input::make('external')->set('form', 'other'),
                Repeater::make('nested')->fields([Input::make('title')]),
            ])->value([[
                'body'     => '<p>Read only</p>',
                'excluded' => 'disabled value',
                'external' => 'other form value',
                'nested'   => [['title' => 'Nested value']],
            ]]),
            Repeater::make('disabled')->disabled()->fields([Input::make('title')])
                ->value([['title' => 'Never submitted']]),
        ];

        $html = (new Builder($fields))->generateForm();
        $token = csrf_token();

        return <<<HTML
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="csrf_token" content="{$token}">
<link rel="stylesheet" href="/repeater/assets/app.css">
<script type="module" src="/repeater/assets/app.js"></script>
</head><body><form id="fixture" method="post" action="/repeater/submit" data-turbo="false">
<input type="hidden" name="_token" value="{$token}">
{$html}
<button type="submit">Submit</button></form><form id="other" method="post" action="/repeater/submit" data-turbo="false">
<input type="hidden" name="_token" value="{$token}"><button type="submit">Other Submit</button></form></body></html>
HTML;
    }
}

/**
 * Keep the fixture independent of attachment persistence while using the real field and controller.
 */
class RepeaterBrowserAttach extends Attach
{
    protected function loadRelatedAttachments(): static
    {
        return $this;
    }
}
