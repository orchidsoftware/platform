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
        'type'    => Color::INFO,
    ];

    public function __construct(array $data = [])
    {
        parent::__construct($data);

        $this->data['time'] = Carbon::now();
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function title(string $title)
    {
        $this->data['title'] = $title;

        return $this;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function message(string $title)
    {
        $this->data['message'] = $title;

        return $this;
    }

    /**
     * @param string $action
     *
     * @return $this
     */
    public function action(string $action)
    {
        $this->data['action'] = $action;

        return $this;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function type(string $type)
    {
        $this->data['type'] = $type;

        return $this;
    }
}
