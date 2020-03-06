<?php

declare(strict_types=1);

namespace Orchid\Tests\App;

class AjaxRecord
{
    /**
     * @var null
     */
    public $query = null;

    /**
     * @var null
     */
    public $key = null;

    /**
     * @return array
     */
    public function handler()
    {
        $data = [
            [
                'id'   => 1,
                'text' => 'Record 1',
            ],
            [
                'id'   => 2,
                'text' => 'Record 2',
            ],
            [
                'id'   => 3,
                'text' => 'Record 3',
            ],
        ];

        if (! is_null($this->key)) {
            foreach ($data as $key => $result) {
                if ($result['id'] === (int) $this->key) {
                    return $data[$key];
                }
            }
        }

        return $data;
    }
}
