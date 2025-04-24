<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Tests\TestUnitCase;

/**
 * Class SourceTest.
 */
class SourceTest extends TestUnitCase
{
    private Model $model;

    protected function setUp(): void
    {
        parent::setUp();

        $model = new class extends Model {
            use AsSource;

            protected $attributes = [
                'preferences' => '{"theme":"dark","notifications":{"email":true,"sms":false}}',
            ];

            protected $fillable = [
                'id',
                'name',
                'options',
                'preferences',
            ];

            protected $casts = [
                'options' => 'array',
                'preferences' => 'json',
            ];

            public function getGreetingAttribute()
            {
                return 'Hello ' . $this->name;
            }
        };

        $model->fill([
            'id' => 8,
            'name' => 'Alexandr Chernyaev',
            'options' => [
                'skills' => [
                    'php' => true,
                ],
                'country' => [
                    'Russia',
                    'Ukraine',
                    'Spain',
                    'Egypt',
                    'Belorussia',
                    'Romania',
                    'Estonia',
                ],
            ],
        ]);

        $model->color = 'red';

        $relationModel = fn(string $name) => new class(['name' => $name]) extends Model {
            protected $fillable = ['name'];
        };

        $model->setRelations([
            'many' => [
                $relationModel('one'),
                $relationModel('two'),
                'three' => $relationModel('three'),
            ],
        ]);

        $this->model = $model;
    }

    public function testGetSimpleAttribute(): void
    {
        $this->assertEquals(8, $this->model->getContent('id'));
        $this->assertEquals('Alexandr Chernyaev', $this->model->getContent('name'));
        $this->assertEquals('red', $this->model->getContent('color'));
    }

    public function testGetArrayAttribute(): void
    {
        $this->assertIsArray($this->model->getContent('options.country'));
        $this->assertContains('Russia', $this->model->getContent('options.country'));

        $this->assertIsBool($this->model->getContent('options.skills.php'));
        $this->assertTrue($this->model->getContent('options.skills.php'));
    }

    public function testGetJsonAttribute(): void
    {
        $this->assertIsArray($this->model->getContent('preferences.notifications'));
        $this->assertArrayHasKey('email', $this->model->getContent('preferences.notifications'));
        $this->assertTrue($this->model->getContent('preferences.notifications.email'));
        $this->assertFalse($this->model->getContent('preferences.notifications.sms'));

        $this->assertIsString($this->model->getContent('preferences.theme'));
        $this->assertSame('dark', $this->model->getContent('preferences.theme'));
    }

    public function testGetRelationByPath(): void
    {
        $name = $this->model->getContent('many.three.name');
        $this->assertSame('three', $name);
    }

    public function testGetNamedRelation(): void
    {
        $related = $this->model->getContent('many.three');
        $this->assertInstanceOf(Model::class, $related);
        $this->assertSame('three', $related->name);
    }

    public function testGetRelationList(): void
    {
        $relations = $this->model->getContent('many');

        $this->assertIsArray($relations);
        $this->assertCount(3, $relations);
        $this->assertSame('one', $relations[0]->name);
        $this->assertSame('two', $relations[1]->name);
        $this->assertSame('three', $relations['three']->name);
    }

    public function testGetAttributeWithAccessor(): void
    {
        $this->assertEquals('Hello Alexandr Chernyaev', $this->model->getContent('greeting'));
    }

    public function testNoAccessToInternalProperties(): void
    {
        $this->assertNull($this->model->getContent('incrementing')); // public
        $this->assertNull($this->model->getContent('fillable')); // property
        $this->assertNull($this->model->getContent('connection'));
    }

    public function testGetNonexistentPathReturnsNull(): void
    {
        $this->assertNull($this->model->getContent('options.invalid'));
        $this->assertNull($this->model->getContent('many.four'));
    }

}
