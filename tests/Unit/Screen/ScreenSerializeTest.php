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
     * Ensures that an empty screen (all properties at their default values) is serialized
     * as a compact empty object, because ModelStateRetrievable skips default-valued properties.
     *
     * @throws ReflectionException
     */
    public function testEmptyProperty(): void
    {
        $screen = app()->make(SerializeScreen::class);
        $serializedScreen = serialize($screen);

        $this->assertSame(
            'O:40:"Orchid\Tests\App\Screens\SerializeScreen":0:{}',
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
     * Tests that a saved Eloquent model is serialized as a model identifier (not its full
     * attributes), and is re-fetched from the database on deserialization.
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

        // Ensure the user's email is NOT present — the model is stored by identifier only
        $this->assertStringNotContainsString($user->email, $serializedScreen);

        DB::enableQueryLog();

        // Deserialize the screen
        $unserializedScreen = unserialize($serializedScreen);
        $query = collect(DB::getQueryLog())->first();

        // Verify the correct SQL query was executed to retrieve the user model
        $this->assertSame('select * from "users" where "users"."id" = ? limit 1', $query['query']);
        $this->assertSame([$user->id], $query['bindings']);

        $this->assertSame($user->getKey(), $unserializedScreen->user->getKey());

        // The unsaved name change is gone after rehydration from DB
        $this->assertNotSame('Changed Name', $unserializedScreen->user->name);
    }

    /**
     * Ensures that an empty screen property is correctly serialized and deserialized
     * when using the ModelStateRetrievable trait inherited from Screen.
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

    /**
     * Tests serialization and deserialization with the ModelStateRetrievable trait.
     *
     * Ensures that an unsaved model is serialized with its attributes intact
     * and is restored as-is upon deserialization (without DB query).
     */
    public function testWithPropertyRetrievableWhenEloquentModelNotSaved(): void
    {
        $user = User::factory()->make([
            'name' => 'Alexandr',
        ]);

        $this->assertNull($user->getKey());

        $screen = app()->make(SerializeRetrievableScreen::class, ['user' => $user]);
        $serializedScreen = serialize($screen);

        $this->assertStringContainsString('Alexandr', $serializedScreen);

        DB::enableQueryLog();

        $unserializedScreen = unserialize($serializedScreen);

        $this->assertEquals('Alexandr', $unserializedScreen->user->name);
        $this->assertCount(0, DB::getQueryLog());
    }

    /**
     * Tests that a public Closure property is safely serialized using SerializableClosure
     * and correctly restored as a callable upon deserialization.
     */
    public function testWithClosure(): void
    {
        $screen = app()->make(SerializeRetrievableScreen::class);
        $screen->callback = fn () => 'hello world';

        $serializedScreen = serialize($screen);

        // The serialized form should contain SerializableClosure, not a raw Closure
        $this->assertStringContainsString('SerializableClosure', $serializedScreen);

        $unserializedScreen = unserialize($serializedScreen);

        $this->assertIsCallable($unserializedScreen->callback);
        $this->assertSame('hello world', ($unserializedScreen->callback)());
    }

    /**
     * Tests that primitive types (int, string) and stdClass objects are safely
     * serialized and restored through the Screen state mechanism.
     */
    public function testWithPrimitivesAndStdObject(): void
    {
        $screen = app()->make(SerializeRetrievableScreen::class);

        // int — differs from the 'Public' string default
        $screen->public = 42;
        $serializedInt = serialize($screen);
        $unserializedInt = unserialize($serializedInt);
        $this->assertSame(42, $unserializedInt->public);

        // string — differs from the 'Public' string default
        $screen->public = 'custom string';
        $serializedStr = serialize($screen);
        $unserializedStr = unserialize($serializedStr);
        $this->assertSame('custom string', $unserializedStr->public);

        // stdClass
        $obj = new \stdClass();
        $obj->key = 'value';
        $screen->public = $obj;
        $serializedObj = serialize($screen);
        $unserializedObj = unserialize($serializedObj);
        $this->assertInstanceOf(\stdClass::class, $unserializedObj->public);
        $this->assertSame('value', $unserializedObj->public->key);
    }
}
