<?php

namespace Orchid\Screen\Concerns;

use Illuminate\Queue\SerializesModels;

/**
 * This trait is designed for managing the state of Eloquent models. It uses
 * the SerializesModels functionality to ensure proper serialization of the model
 * when working with queues and allows loading the state of the model from the database.
 *
 * Use this trait in classes where you need to load the model's state
 * from the database, such as in screens or other components that work with models.
 */
trait ModelStateRetrievable
{
    use SerializesModels;
}
