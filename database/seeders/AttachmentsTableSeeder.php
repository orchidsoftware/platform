<?php

namespace Orchid\Platform\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Orchid\Attachment\File;

class AttachmentsTableSeeder extends Seeder
{
    public $storage = 'public';

    public $filecounts = 15;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < $this->filecounts; $i++) {
            $this->addfile();
        }
    }

    public function addfile()
    {
        $file = UploadedFile::fake()->image('attachment.jpg', 640, 480);

        $attachment = (new File($file, $this->storage))->load();

        return $attachment->toArray();
    }
}
