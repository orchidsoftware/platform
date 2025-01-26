<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Orchid\Platform\Orchid;
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
    public function test_files_are_minified(): void
    {
        $maxCssSize = 500 * 1028; //  ~500 kb
        $maxJsSize = 2 * 1028 * 1028; // ~2 mb
        $maxVendorSize = 2 * 1028 * 1028; // ~2 mb

        $this->assertLessThan($maxCssSize,
            filesize(Orchid::path('/public/css/orchid.css')),
            'File orchid.css more '.Formats::formatBytes($maxCssSize)
        );

        $this->assertLessThan($maxJsSize,
            filesize(Orchid::path('/public/js/orchid.js')),
            'File orchid.js more '.Formats::formatBytes($maxJsSize)
        );

        $this->assertLessThan($maxVendorSize,
            filesize(Orchid::path('/public/js/vendor.js')),
            'File vendor.js more '.Formats::formatBytes($maxVendorSize)
        );
    }
}
