<?php

declare(strict_types=1);

namespace Orchid\Platform\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupportMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var \Illuminate\Http\Request
     */
    public $request;

    /**
     * SupportMail constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->to(config('platform.support'))
            ->subject('Сообщение с веб-сайта')
            ->markdown('platform::emails.support', [
                'message' => $this->request->get('message'),
                'email'   => $this->request->get('email'),
                'name'    => $this->request->get('name'),
            ]);
    }
}
