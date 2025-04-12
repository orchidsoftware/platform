<?php

namespace Orchid\Screen\Concerns;

use Orchid\Screen\Repository;
use Illuminate\Support\Facades\Crypt;

trait InteractsWithEncryptedState
{
    /**
     * This method extracts the state from a request parameter.
     * If the '_state' parameter is missing, an empty Repository object is returned.
     * Otherwise, the state is extracted from the encrypted '_state' parameter, deserialized and returned.
     *
     * @throws \Psr\Container\ContainerExceptionInterface - If the container cannot provide the dependency injection for a class.
     * @throws \Psr\Container\NotFoundExceptionInterface  - If the container cannot find a required dependency injection for a class.
     *
     * @return \Orchid\Screen\Repository - The extracted state.
     */
    protected function extractState(?string $state = null): Repository
    {
        if($state === null) {
            $state = request()->get('_state', session()->get('_state'));
        }

        // Check if the '_state' parameter is present
        if ($state === null) {
            // Return an empty Repository object
            return new Repository;
        }

        // deserialize '_state' parameter
        $decoded = Crypt::decrypt($state);

        return new Repository(get_object_vars($decoded));
    }

    /**
     * Serializes the current state of the screen into a string.
     *
     * @throws \Laravel\SerializableClosure\Exceptions\PhpVersionNotSupportedException If the PHP version is not supported for serialization.
     *
     * @return string The serialized state.
     */
    protected function serializableState(): string
    {
        return Crypt::encrypt($this);
    }
}
