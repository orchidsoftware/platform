<?php

declare(strict_types=1);

namespace Orchid\Platform\Notifications;

use Carbon\Carbon;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Orchid\Support\Color;

class DashboardMessage extends DatabaseMessage
{
    /**
     * The data that should be stored with the notification.
     *
     * @var array
     */
    public $data = [
        'title'   => '',
        'action'  => '#',
        'message' => '',
    ];

    public function __construct(array $data = [])
    {
        $default = [
            'time' => Carbon::now(),
            'type' => Color::INFO->name(),
        ];

        parent::__construct(array_merge($default, $data));
    }

    /**
     * @return $this
     */
    public function title(string $title): self
    {
        $this->data['title'] = $title;

        return $this;
    }

    /**
     * @return $this
     */
    public function message(string $title): self
    {
        $this->data['message'] = $title;

        return $this;
    }

    /**
     * @return $this
     */
    public function action(string $action): self
    {
        $this->data['action'] = $action;

        return $this;
    }

    /**
     * @return $this
     */
    public function type(Color $color): self
    {
        $this->data['type'] = $color->name();

        return $this;
    }
}
