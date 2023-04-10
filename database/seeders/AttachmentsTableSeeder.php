<?php

namespace Orchid\Platform\Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File as MakeFile;
use Illuminate\Support\Facades\Storage;
use Orchid\Platform\Attachments\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
        $dirimages = config('filesystems.disks.public.root').DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR; //date('Y/m/d');

        //if(!MakeFile::exists($dirimages))
        //{
        MakeFile::makeDirectory($dirimages, $mode = 0777, $recursive = true, $force = true);
        //}
        $faker = Faker::create();

        $image = $faker->image($dirimages, $width = 640, $height = 480);
        $file = new UploadedFile($image, $image, null, filesize($image), null, true);

        $attachment = app()->make(File::class, [
            'file'    => $file,
            'storage' => Storage::disk($this->storage),
        ])->load();

        //dd($attachment->toArray());
        return $attachment->toArray();
    }
}
