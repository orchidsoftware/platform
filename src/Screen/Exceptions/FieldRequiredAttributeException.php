<?php

declare(strict_types=1);

namespace Orchid\Screen\Exceptions;

use Exception;
use Throwable;

/**
 * Class FieldRequiredAttributeException.
 */
class FieldRequiredAttributeException extends Exception
{
    /**
     * FieldRequiredAttributeException constructor.
     *
     * @param string         $attribute
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(string $attribute = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($attribute, $code, $previous);
        $this->message = 'Field must have the following attribute: '.$attribute;
    }
}
