<?php
/**
 * Created by PhpStorm.
 * User: joker
 * Date: 16.11.16
 * Time: 11:18
 */

namespace Orchid\Foundation\Http\Forms\Systems\Localization;

use Orchid\Foundation\Services\Forms\Form;

class LocalizationMainForm extends Form
{

    public $name = 'Main';

    /**
     * @return mixed
     */
    public function persist()
    {
        // TODO: Implement persist() method.
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return view('dashboard::container.systems.localization.info', []);
    }
}