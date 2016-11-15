<?php

namespace Orchid\Foundation\Services\Notification;

use Orchid\Foundation\Core\Models\Notification;

trait NotificationTrait
{
    /**
     * @param $type
     * @param $text
     * @param null $url
     *
     * @return $this
     */
    public function notificationCreate($type, $text, $url = null)
    {
        Notification::create([
            'user_id' => $this->id,
            'type'    => $type,
            'url'     => $url,
            'text'    => $text,
            'read'    => false,
        ]);

        return $this;
    }

    /**
     * @return $this
     */
    public function notificationAllRead()
    {
        if (!is_null($this->notifications()->first())) {
            return $this->notifications()->update([
                'read' => true,
            ]);
        } else {
            return $this;
        }
    }

    /**
     * @return mixed
     */
    public function notifications()
    {
        return $this->belongsTo(Notification::class, 'id', 'user_id');
    }

    /**
     * @return mixed
     */
    public function clearNotification()
    {
        return $this->notifications()->delete();
    }

    /**
     * @param array $type
     *
     * @return mixed
     */
    public function listNotification($type = [])
    {
        if (empty($type)) {
            return $this->notifications()
                ->get()
                ->groupBy('type');
        } else {
            return $this->notifications()
                ->whereIn('type', $type)
                ->get()
                ->groupBy('type');
        }
    }
}
