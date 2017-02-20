<?php
/**
 * Created by PhpStorm.
 * User: joker
 * Date: 16.02.17
 * Time: 11:20.
 */

namespace Orchid\Foundation\Events\Tools;

use Illuminate\Queue\SerializesModels;
use Orchid\Foundation\Http\Forms\Tools\Advertising\AdvertisingFormGroup;

class AdvertisingEvent
{
    use SerializesModels;

    /**
     * @var
     */
    protected $form;

    /**
     * Create a new event instance.
     * SomeEvent constructor.
     *
     * @param AdvertisingFormGroup $form
     */
    public function __construct(AdvertisingFormGroup $form)
    {
        $this->form = $form;
    }
}
