<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsMultiSource;
use Orchid\Tests\TestUnitCase;

/**
 * Class SourceTest.
 */
class MultiSourceTest extends TestUnitCase
{
    /**
     * @var Model
     */
    protected $model;

    protected function setUp(): void
    {
        parent::setUp();

        $model = new class extends Model {
            use AsMultiSource;

            protected $fillable = [
                'content',
            ];

            protected $casts = [
                'options' => 'array',
            ];
        };

        $this->model = $model->fill([
            'content' => [
                'en' => [
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
                'ru' => [
                    'country' => [
                        'Россия',
                        'Украина',
                        'Испания',
                        'Египет',
                        'Беларусь',
                        'Румыния',
                        'Эстония',
                    ],
                ],
            ],
        ]);
    }

    public function testMultiLanguageAttribute(): void
    {
        $this->assertContains('Russia', $this->model->getContent('country', 'en'));
        $this->assertContains('Россия', $this->model->getContent('country', 'ru'));
    }

    public function testMultiLanguageFallBack(): void
    {
        $this->assertContains('Spain', $this->model->getContent('country', 'es'));
    }
}
