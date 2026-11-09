<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPromotedPropertyRector;
use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use Rector\PHPUnit\PHPUnit120\Rector\Class_\AllowMockObjectsForDataProviderRector;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use RectorLaravel\Rector\ClassMethod\MigrateToSimplifiedAttributeRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/config',
        __DIR__.'/src',
        __DIR__.'/tests',
        __DIR__.'/workbench',
    ])
    ->withPreparedSets(
        deadCode: true,
        codeQuality: false,
        codingStyle: false,
        privatization: true,
        instanceOf: true,
        earlyReturn: true,
    )
    ->withComposerBased(
        phpunit: true,
        laravel: true,
    )
    ->withParallel(
        timeoutSeconds: 120,
        maxNumberOfProcess: 8,
        jobSize: 20,
    )
    ->withSkip([
        // Keep the suite compatible with PHPUnit 10 and 11.
        AllowMockObjectsForDataProviderRector::class,
        ClosureToArrowFunctionRector::class,
        // These accessors are part of the public Attachment API.
        MigrateToSimplifiedAttributeRector::class => [
            __DIR__.'/src/Attachment/Models/Attachment.php',
        ],
        // Blade::component registers class components; aliasComponent registers views.
        RenameMethodRector::class => [
            __DIR__.'/src/Platform/Providers/FoundationServiceProvider.php',
        ],
        // Serialization tests intentionally include private promoted properties.
        RemoveUnusedPromotedPropertyRector::class => [
            __DIR__.'/tests/App/Screens/SerializeScreen.php',
            __DIR__.'/tests/App/Screens/SerializeRetrievableScreen.php',
        ],
    ])
    ->withMemoryLimit('3G')
    ->withPhpSets(php83: true);
