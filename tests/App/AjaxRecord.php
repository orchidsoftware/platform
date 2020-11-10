<?php

declare(strict_types=1);

namespace Orchid\Tests\App;

class AjaxRecord
{
    /**
     * @var null
     */
    public $query;

    /**
     * @var null
     */
    public $key;

    /**
     * @return array
     */
    public function handler(): array
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

        if ($this->key !== null) {
            foreach ($data as $key => $result) {
                if ($result['id'] === (int) $this->key) {
                    return $data[$key];
                }
            }
        }

        return $data;
    }
}
