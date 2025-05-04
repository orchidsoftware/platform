<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Orchid\Platform\Dashboard;
use Orchid\Support\Formats;
use Orchid\Tests\TestUnitCase;

class PublishedResourceTest extends TestUnitCase
{
    public function testFilesArePublished(): void
    {
        $this->assertFileExists(Dashboard::path('/public/assets/app.css'));
        $this->assertFileExists(Dashboard::path('/public/assets/app.js'));
    }

    /**
     * This test will check the size of the published files,
     * so as not to accidentally publish non-minified versions.
     *
     * Usually to solve this problem you only need to run the Laravel Mix:
     *  `npm run build`
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

    public function testManifestFilesHaveVersion(): void
    {
        $manifestPath = Dashboard::path('/public/manifest.json');
        $this->assertFileExists($manifestPath, 'Manifest file does not exist.');

        $manifestContent = file_get_contents($manifestPath);
        $this->assertNotFalse($manifestContent, 'Failed to read manifest file.');

        $manifest = json_decode($manifestContent, true);
        $this->assertIsArray($manifest, 'Manifest is not a valid JSON array.');

        foreach ($manifest as $source => $data) {
            $this->assertArrayHasKey('file', $data, "Missing 'file' key in manifest entry: $source");

            $file = $data['file'];

            $this->assertStringContainsString(
                '?v=',
                $file,
                "File '$file' for source '$source' is missing version query parameter '?v='"
            );
        }
    }

    public function testManifestFilesExist(): void
    {
        $manifestPath = Dashboard::path('/public/manifest.json');
        $manifest = json_decode(file_get_contents($manifestPath), true);

        foreach ($manifest as $data) {
            $filePath = explode('?', $data['file'])[0]; // Remove query string
            $fullPath = Dashboard::path("/public/{$filePath}");

            $this->assertFileExists($fullPath, "Asset file does not exist: {$filePath}");
        }
    }

    public function testManifestEntriesHaveIntegrity(): void
    {
        $manifestPath = Dashboard::path('/public/manifest.json');
        $manifest = json_decode(file_get_contents($manifestPath), true);

        foreach ($manifest as $source => $data) {
            $this->assertArrayHasKey('integrity', $data, "Missing 'integrity' for $source");
            $this->assertMatchesRegularExpression('/^sha(256|384|512)-/', $data['integrity'], "Invalid integrity format for $source");
        }
    }

    public function testManifestIsValidJson(): void
    {
        $manifestPath = Dashboard::path('/public/manifest.json');
        $json = file_get_contents($manifestPath);
        $this->assertNotFalse($json, 'Manifest file cannot be read.');

        $decoded = json_decode($json, true);
        $this->assertIsArray($decoded, 'Manifest JSON is not an array.');
        $this->assertSame(JSON_ERROR_NONE, json_last_error(), 'Invalid JSON: '.json_last_error_msg());
    }
}
