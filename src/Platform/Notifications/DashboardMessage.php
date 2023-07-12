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
        'action'  => '#', // URL for the "View" button
        'message' => '',
    ];

    /**
     * Create a new instance of DashboardMessage with the given data.
     *
     * @param array $data An array of data to be merged with default message data.
     */
    public function __construct(array $data = [])
    {
        $default = [
            'time' => Carbon::now(), // The timestamp this message was created.
            'type' => Color::INFO->name(), // The type of message (INFO, WARNING, SUCCESS, or ERROR).
        ];

        parent::__construct(array_merge($default, $data));
    }

    /**
     * Set the title of the message.
     *
     * @param string $title The title to be set.
     *
     * @return $this
     */
    public function title(string $title): self
    {
        $this->data['title'] = $title;

        return $this;
    }

    /**
     * Set the message content.
     *
     * @param string $message The message text to be set.
     *
     * @return $this
     */
    public function message(string $message): self
    {
        $this->data['message'] = $message;

        return $this;
    }

    /**
     * Set the URL for the "View" button. This is the URL that the user will be redirected to
     * when they click the "View" button on this notification in the dashboard.
     *
     * @param string $action The URL to be set.
     *
     * @return $this
     */
    public function action(string $action): self
    {
        $this->data['action'] = $action;

        return $this;
    }

    /**
     * Set the type of the message.
     *
     * @param Color $color The color representing the new type of the message.
     *
     * @return $this
     */
    public function type(Color $color): self
    {
        $this->data['type'] = $color->name();

        return $this;
    }
}
