<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\App;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Orchid\Platform\Models\User;
use Orchid\Tests\App\Screens\QueryWithoutDefaultValueScreen;
use Orchid\Tests\TestFeatureCase;

/**
 * Class ScreenWithoutDefaultQueryTest.
 */
class ScreenWithoutDefaultQueryTest extends TestFeatureCase
{
    public function testWhenNoParameterIsPassed(): void
    {
        $screen = new QueryWithoutDefaultValueScreen();

        $data = $this->invokeMethod(
            $screen,
            'callMethod',
            ['query']
        );

        $this->assertInstanceOf(User::class, $data['user']);
    }

    public function testWhenAParameterIsPassedAndTheModelExists(): void
    {
        $user = $this->createAdminUser();

        $screen = new QueryWithoutDefaultValueScreen();

        $data = $this->invokeMethod(
            $screen,
            'callMethod',
            ['query', ['user' => $user->id]]
        );

        $this->assertSame($user->id, $data['user']->id);
    }

    public function testWhenAParameterIsPassedAndTheModelDoesNotExist(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $screen = new QueryWithoutDefaultValueScreen();

        $this->invokeMethod(
            $screen,
            'callMethod',
            ['query', ['user' => 0]]
        );
    }

    public function invokeMethod(&$object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
