<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen;

use Illuminate\Support\Facades\DB;
use Orchid\Platform\Models\User;
use Orchid\Tests\App\Screens\SerializeRetrievableScreen;
use Orchid\Tests\App\Screens\SerializeScreen;
use Orchid\Tests\TestUnitCase;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

class ScreenSerializeTest extends TestUnitCase
{
    /**
     * Ensures that an empty screen property is correctly serialized and deserialized.
     *
     * @throws ReflectionException
     */
    public function testEmptyProperty(): void
    {
        $screen = app()->make(SerializeScreen::class);
        $serializedScreen = serialize($screen);

        $this->assertSame(
            'O:40:"Orchid\Tests\App\Screens\SerializeScreen":2:{s:6:"public";s:6:"Public";s:4:"user";N;}',
            $serializedScreen,
            'The serialized string does not match the expected output.'
        );

        $unserializedScreen = unserialize($serializedScreen);
        $reflectionClass = new ReflectionClass($unserializedScreen);

        collect($reflectionClass->getProperties())
            ->each(function (ReflectionProperty $property) use ($unserializedScreen) {
                $this->assertTrue(
                    $property->isInitialized($unserializedScreen),
                    "The property {$property->getName()} is not initialized."
                );
            });
    }

    /**
     * Tests the serialization and deserialization of a screen with a populated property.
     *
     * The user's name is intentionally changed without saving to test how this affects serialization.
     *
     * @throws ReflectionException
     */
    public function testWithProperty(): void
    {
        $user = User::factory()->create();

        // Intentionally change the user's name without saving it
        $user->name = 'Changed Name';

        $screen = app()->make(SerializeScreen::class, ['user' => $user]);
        $serializedScreen = serialize($screen);

        // Ensure the user's email is present in the serialized object
        $this->assertStringContainsString($user->email, $serializedScreen);

        DB::enableQueryLog();

        // Deserialize the screen
        $unserializedScreen = unserialize($serializedScreen);
        $queries = DB::getQueryLog();

        // Ensure no SQL queries were executed during deserialization
        $this->assertEmpty($queries);

        $this->assertSame($unserializedScreen->user->getKey(), $user->getKey());
        $this->assertSame($unserializedScreen->user->name, 'Changed Name');
    }

    /**
     * Ensures that an empty screen property is correctly serialized and deserialized
     * when using the ModelStateRetrievable trait.
     *
     * @throws ReflectionException
     */
    public function testEmptyPropertyRetrievable(): void
    {
        $screen = app()->make(SerializeRetrievableScreen::class);
        $serializedScreen = serialize($screen);

        $this->assertSame(
            'O:51:"Orchid\Tests\App\Screens\SerializeRetrievableScreen":0:{}',
            $serializedScreen,
            'The serialized string does not match the expected output.'
        );

        $unserializedScreen = unserialize($serializedScreen);
        $reflectionClass = new ReflectionClass($unserializedScreen);

        collect($reflectionClass->getProperties())
            ->each(function (ReflectionProperty $property) use ($unserializedScreen) {
                $this->assertTrue(
                    $property->isInitialized($unserializedScreen),
                    "The property {$property->getName()} is not initialized."
                );
            });
    }

    /**
     * Tests serialization and deserialization with the ModelStateRetrievable trait.
     *
     * Ensures that only the necessary information is serialized, and the model is
     * retrieved via an SQL query upon deserialization.
     *
     * @throws ReflectionException
     */
    public function testWithPropertyRetrievable(): void
    {
        $user = User::factory()->create();

        // Intentionally change the user's name without saving it
        $user->name = 'Changed Name';

        $screen = app()->make(SerializeRetrievableScreen::class, ['user' => $user]);
        $serializedScreen = serialize($screen);

        // Ensure the user's email is not present in the serialized object
        $this->assertStringNotContainsString($user->email, $serializedScreen);

        DB::enableQueryLog();

        // Deserialize the screen
        $unserializedScreen = unserialize($serializedScreen);
        $query = collect(DB::getQueryLog())->first();

        // Verify the correct SQL query was executed to retrieve the user model
        $this->assertSame('select * from "users" where "users"."id" = ? limit 1', $query['query']);
        $this->assertSame([$user->id], $query['bindings']);

        $this->assertSame($user->getKey(), $unserializedScreen->user->getKey());

        // Ensure the user's name after deserialization does not match the unsaved change
        $this->assertNotSame('Changed Name', $unserializedScreen->user->name);
    }
}
