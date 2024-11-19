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
    /**
     * @var Model
     */
    protected $model;

    protected function setUp(): void
    {
        $model = new class extends Model
        {
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
                'options'     => 'array',
                'preferences' => 'json',
            ];

            public function getGreetingAttribute()
            {
                return 'Hello '.$this->name;
            }
        };

        $model->fill([
            'id'      => 8,
            'name'    => 'Alexandr Chernyaev',
            'options' => [
                'skills'  => [
                    'php'  => true,
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
        $model->setRelations(['many' => ['one', 'two', 'three' => 84]]);

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

    public function testGetRelation(): void
    {
        $this->assertIsInt($this->model->getContent('many.three'));
        $this->assertEquals(84, $this->model->getContent('many.three'));

        $this->assertContains('one', $this->model->getContent('many'));
        $this->assertContains('two', $this->model->getContent('many'));
        $this->assertEquals('one', $this->model->getContent('many')[0]);
    }

    public function testGetAttributeWithAccessor()
    {
        $this->assertEquals('Hello Alexandr Chernyaev', $this->model->getContent('greeting'));
    }

    public function testNoAccessToProperties(): void
    {
        $this->assertNull($this->model->getContent('incrementing')); // public
        $this->assertNull($this->model->getContent('fillable')); // property
        $this->assertNull($this->model->getContent('connection'));
    }
}
