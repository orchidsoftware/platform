<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen;

use Orchid\Screen\Repository;
use Orchid\Screen\Screen;
use Orchid\Tests\TestUnitCase;
use Orchid\Tests\Unit\Screen\Screens\ScreenWithInheritedProperties;

class ScreenFillPublicPropertyTest extends TestUnitCase
{
    /**
     * Tests that the `fillPublicProperty` method correctly fills public properties
     * with various data types: array, object, boolean, string, and float.
     *
     * @throws \ReflectionException
     *
     * @return void
     */
    public function testFillPublicPropertyWithVariousValueTypes(): void
    {
        $screen = new class extends Screen
        {
            public $simpleArrayProperty;
            public $objectProperty;
            public $booleanFalseProperty;
            public $booleanTrueProperty;
            public $stringProperty;
            public $floatProperty;
            public $nullProperty;
            public $assocArrayProperty;
            public $customObjectProperty;

            public function layout(): iterable
            {
                return [];
            }

            public function fillForTest(Repository $repository): void
            {
                $this->fillPublicProperty($repository);
            }
        };

        // Define test data with meaningful property names
        $data = [
            'simpleArrayProperty'  => ['item1', 'item2'], // Simple array
            'objectProperty'       => (object) ['key' => 'value'], // Object
            'booleanFalseProperty' => false, // Boolean false
            'booleanTrueProperty'  => true, // Boolean true
            'stringProperty'       => 'string value', // String
            'floatProperty'        => 3.14, // Float
            'nullProperty'         => null, // Null
            'assocArrayProperty'   => ['key1' => 'value1', 'key2' => 'value2'], // Associative array
            'customObjectProperty' => new \stdClass(), // Custom object (stdClass)
        ];

        // Initialize public properties for testing
        foreach (array_keys($data) as $property) {
            $screen->{$property} = null; // Set property to null initially
        }

        $repository = new Repository($data);

        $screen->fillForTest($repository);

        // Assert that each public property is set correctly
        foreach ($data as $property => $expectedValue) {
            $this->assertEquals($expectedValue, $screen->{$property}, "Failed asserting that property '$property' is set correctly.");
        }
    }

    /**
     * Tests that the `getPublicPropertyNames` method correctly returns all public properties,
     * including those defined in the parent class, ensuring they are accessible for filling.
     */
    public function testGetPublicPropertyNamesIncludesInheritedProperties(): void
    {
        $screen = new ScreenWithInheritedProperties();

        // Use reflection to access the protected method getPublicPropertyNames
        $reflection = new \ReflectionClass($screen);
        $method = $reflection->getMethod('getPublicPropertyNames');
        $method->setAccessible(true);

        // Invoke the protected method and get the result
        $result = $method->invoke($screen);

        // Assert that the result contains all public properties, including those from the parent class
        $this->assertEquals($result->all(), [
            'childProperty1',
            'childProperty2',
            'parentProperty1',
            'parentProperty2',
        ]);
    }
}
