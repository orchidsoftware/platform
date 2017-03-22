<?php

namespace Orchid\Defender;

use Illuminate\Support\Facades\Storage;

class Export
{
    /**
     * Current date.
     *
     * @var
     */
    public $date;

    /**
     * Export constructor.
     */
    public function __construct()
    {
        $this->date = date('Y-m-j');
        $this->storage = Storage::disk('local');
    }

    /**
     * Create log file.
     *
     * @param Defender $defender
     */
    public function export(Defender $defender)
    {
        $content = json_encode($defender->dangerFiles);
        $name = 'defender/defender-' . $this->date . '.json';

        if ($this->storage->exists($name)) {
            $this->storage->delete($name);
        }

        $this->storage->put($name, $content);
    }
}
