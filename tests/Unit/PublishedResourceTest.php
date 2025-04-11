<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Orchid\Platform\Dashboard;
use Orchid\Support\Formats;
use Orchid\Tests\TestUnitCase;

class PublishedResourceTest extends TestUnitCase
{
    /**
     * This test will check the size of the published files,
     * so as not to accidentally publish non-minified versions.
     *
     * Usually to solve this problem you only need to run the Laravel Mix:
     *  `npm run production`
     *
     * These are approximate values that can be changed.
     */
    public function testFilesAreMinified(): void
    {
        $maxCssSize = 550 * 1028; //  ~550 kb
        $maxJsSize = 2 * 1028 * 1028; // ~2 mb

        $this->assertLessThan($maxCssSize,
            filesize(Dashboard::path('/public/assets/app.css')),
            'File orchid.css more '.Formats::formatBytes($maxCssSize)
        );

        $this->assertLessThan($maxJsSize,
            filesize(Dashboard::path('/public/assets/app.js')),
            'File orchid.js more '.Formats::formatBytes($maxJsSize)
        );
    }
}
