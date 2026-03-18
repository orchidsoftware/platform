<?php

namespace Orchid\Screen\Concerns;

use Illuminate\Support\Facades\Crypt;
use Laravel\SerializableClosure\Exceptions\PhpVersionNotSupportedException;
use Orchid\Screen\Repository;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

trait InteractsWithEncryptedState
{
    /**
     * This method extracts the state from a request parameter.
     * If the '_state' parameter is missing, an empty Repository object is returned.
     * Otherwise, the state is extracted from the encrypted '_state' parameter, deserialized and returned.
     *
     * @throws ContainerExceptionInterface - If the container cannot provide the dependency injection for a class.
     * @throws NotFoundExceptionInterface  - If the container cannot find a required dependency injection for a class.
     *
     * @return Repository - The extracted state.
     */
    protected function extractState(?string $state = null): Repository
    {
        if ($state === null) {
            $state = request()->input('_state', session()->get('_state'));
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
     * @throws PhpVersionNotSupportedException If the PHP version is not supported for serialization.
     *
     * @return string The serialized state.
     */
    protected function serializableState(): string
    {
        return Crypt::encrypt($this);
    }
}
