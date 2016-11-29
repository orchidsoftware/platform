<?php namespace Orchid\Foundation\Services\Image;

use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

trait ImageUpload
{


    /**
     * @return string
     */
    protected function getImageLoad()
    {
        if(is_null($this->attributes['avatar'])){
            return $this->attributes['avatar'];
        }else{
            return '/image' . $this->attributes['avatar'];
        }

    }

    /**
     * @param UploadedFile $avatar
     * @param array $options
     */
    protected function setImageLoad(
        UploadedFile $avatar,
        $options = [
            'width' => '100',
            'height' => '100',
            'quality' => '60'
        ]
    ) {
        Storage::disk('public')->makeDirectory(date("Y/m/d") . '/' . $this->table);
        $name = '/' . date("Y/m/d") . '/' . $this->table . '/' . hash('crc32b',
                time()) . '.' . $avatar->getClientOriginalExtension();
        $path = storage_path('app/public/' . $name);
        Image::make($avatar)->resize($options['width'], $options['height'])->save($path, $options['quality']);
        $this->attributes['avatar'] = $name;
        if (isset($this->original['avatar']) &&
            !empty($this->original['avatar'])
        ) {
            Storage::disk('public')->delete($this->original['avatar']);
        }
    }


}