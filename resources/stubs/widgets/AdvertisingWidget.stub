<?php

namespace DummyNamespace;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Orchid\Core\Models\Post;
use Orchid\Widget\Service\Widget;

class AdvertisingWidget extends Widget
{
    /**
     * @var static
     */
    protected $date;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->date = Carbon::now();
    }

    /**
     * @param string $key
     *
     * @return null
     */
    public function run($key = '')
    {
        $post = Post::type('advertising')->where('options->lang->'.App::getLocale())
            ->where('options->category', $key)
            ->where('options->startDate', '<', $this->date->timestamp)
            ->where('options->endDate', '>', $this->date->timestamp)
            ->first();

        if (!is_null($post)) {
            return $post->getContent('code');
        }
    }
}
