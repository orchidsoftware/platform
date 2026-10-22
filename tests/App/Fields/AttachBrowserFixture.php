<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Fields;

use Orchid\Screen\Builder;
use Orchid\Screen\Fields\Attach;
use Orchid\Screen\Fields\Repeater;

class AttachBrowserFixture
{
    public const IMAGE = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';

    public const FILENAME = 'photo" onload="window.attachExecuted = true" data-injected="yes';

    public static function attachment(int $id = 11): array
    {
        return ['id' => $id, 'url' => self::IMAGE, 'original_name' => self::FILENAME, 'mime' => 'image/gif'];
    }

    public static function render(): string
    {
        $fields = [
            AttachBrowserField::make('stored')->multiple()->value([self::attachment()]),
            AttachBrowserField::make('uploaded')->multiple()->uploadUrl('/attach/upload'),
            AttachBrowserField::make('literal" $& {url}')->multiple()->value([[
                'id'            => 'id" $& {url}',
                'url'           => '/attach/image?literal="&replacement=$&',
                'original_name' => 'literal " <img src=x onerror=window.attachExecuted=true> & $& {url}',
                'mime'          => 'image/gif',
            ], [
                'id'            => 'external', 'url' => 'https://example.com/image.png?token=$&',
                'original_name' => 'External', 'mime' => 'image/png',
            ]]),
            Repeater::make('rows')->cloneableRows()->fields([
                AttachBrowserField::make('files')->multiple(),
            ])->value([['files' => [
                ['id' => 42, 'url' => self::IMAGE, 'original_name' => 'normal.png', 'mime' => 'image/png'],
            ]]]),
        ];
        $html = (new Builder($fields))->generateForm();
        $token = csrf_token();

        return <<<HTML
<!doctype html><html><head><meta charset="utf-8"><meta name="csrf_token" content="{$token}">
<script>window.attachExecuted = false;</script>
<link rel="stylesheet" href="/attach/assets/app.css"><script type="module" src="/attach/assets/app.js"></script>
</head><body data-controller="html-load"><form id="fixture" method="post" action="/attach/submit" data-turbo="false">
<input type="hidden" name="_token" value="{$token}">{$html}<button type="submit">Submit</button>
</form></body></html>
HTML;
    }
}

class AttachBrowserField extends Attach
{
    protected function loadRelatedAttachments(): static
    {
        return $this;
    }
}
