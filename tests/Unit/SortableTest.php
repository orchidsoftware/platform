<?php

namespace Orchid\Tests\Unit;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Orchid\Attachment\File;
use Orchid\Attachment\Models\Attachment;
use Orchid\Platform\Concerns\Sortable;
use Orchid\Tests\TestUnitCase;

class SortableTest extends TestUnitCase
{
    public function testNewModel(): void
    {
        $model = new class extends Model
        {
            use Sortable;
            /**
             * @var array
             */
            protected $fillable = [
                'name',
                'order',

            ];

            /**
             * @var \string[][][]
             */
            protected $attributes = [
                'order' => 0,
            ];
        };

        $model->id = 1;

        $this->assertEquals('order', $model->getSortColumnName());
        $this->assertEquals(0, $model->getSortColumnValue());

        $model->setSortColumn('3');
        $this->assertEquals(3, $model->getSortColumnValue());

    }

    public function testForAttachment()
    {
        $first_file = UploadedFile::fake()->create('first-file');
        $first_upload = (new File($first_file, 'public'))->load();

        $two_file = UploadedFile::fake()->create('two-file');
        $two_upload = (new File($two_file, 'public'))->load();

        $this->assertEquals('sort', $first_upload->getSortColumnName());
        $this->assertEquals(0, $first_upload->getSortColumnValue());
        $this->assertEquals(0, $first_upload->sort);

        $first_upload->setSortColumn('3')->save();
        $this->assertEquals(3, $first_upload->getSortColumnValue());
        $this->assertEquals(3, $first_upload->sort);

        $this->assertEquals($two_upload->id, Attachment::sorted()->get()->first()->id);

        $two_upload->setSortColumn('9')->save();
        $this->assertEquals($first_upload->id, Attachment::sorted()->get()->first()->id);
    }
}
