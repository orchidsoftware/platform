<?php

declare(strict_types=1);

namespace Orchid\Press\Exceptions;

/**
 * Class EntityTypeException.
 */
class EntityTypeException extends \Exception
{
    /**
     * EntityTypeException constructor.
     *
     * @param string $type
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $type = '', int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($type, $code, $previous);
        $this->message = 'Field '.$type.' does not exist or inheritance FieldContract';
    }
}
