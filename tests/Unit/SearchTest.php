<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Builder;
use Orchid\Platform\Searchable;
use Orchid\Tests\TestUnitCase;

class SearchTest extends TestUnitCase
{
    private const LABEL = 'Users';
    private const TITLE = 'Alexandr Chernyaev';
    private const SUB_TITLE = 'Developer';
    private const URL = 'http://example.com/user/45';
    private const AVATAR = 'http://example.com/img/user/45.jpg';

    public function testDefaultSearchable(): void
    {
        $model = new class extends Model {
            use Searchable;

            protected $fillable = [
                'label',
                'title',
                'subTitle',
                'url',
                'avatar',
            ];
        };

        $model->fill([
            'label'    => self::LABEL,
            'title'    => self::TITLE,
            'subTitle' => self::SUB_TITLE,
            'url'      => self::URL,
            'avatar'   => self::AVATAR,
        ]);

        $this->assertEquals($model->searchLabel(), self::LABEL);
        $this->assertEquals($model->searchTitle(), self::TITLE);
        $this->assertEquals($model->searchSubTitle(), self::SUB_TITLE);
        $this->assertEquals($model->searchUrl(), self::URL);
        $this->assertEquals($model->searchAvatar(), self::AVATAR);
    }

    public function testCustomSearchable(): void
    {
        $model = new class extends Model {
            use Searchable;

            protected $fillable = [
                'label',
                'title',
                'subTitle',
                'url',
                'avatar',
            ];

            /**
             * @return string
             */
            public function searchLabel(): ?string
            {
                return 'Roles';
            }
        };

        $model->fill([
            'label'    => self::LABEL,
        ]);

        $this->assertEquals($model->searchLabel(), 'Roles');
        $this->assertInstanceOf(Builder::class, $model->searchQuery(''));
    }
}
