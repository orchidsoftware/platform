<?php namespace Orchid\Defender\Utilities\Expression;


use Orchid\Defender\Utilities\Address\AddressInterface;
use Orchid\Defender\Utilities\Address\IPv4;
use Orchid\Defender\Utilities\Address\IPv6;
use Orchid\Defender\Exception\InvalidExpressionException;

class Literal implements ExpressionInterface
{
    protected $expression;

    public function __construct($expression)
    {
        $expression = strtolower(trim($expression));

        if (IPv4::isValid($expression)) {
            $ip = new IPv4($expression);
        } elseif (IPv6::isValid($expression)) {
            $ip = new IPv6($expression);
        } else {
            throw new InvalidExpressionException('Expression must be either a valid IPv4 or IPv6 address.');
        }

        $this->expression = $ip->getCompact();
    }

    /**
     * check whether the expression matches an address
     *
     * @param  AddressInterface $address
     * @return boolean
     */
    public function matches(AddressInterface $address)
    {
        return $address->getCompact() === $this->expression;
    }
}