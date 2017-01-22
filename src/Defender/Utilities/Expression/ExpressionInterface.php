<?php namespace Orchid\Defender\Utilities\Expression;


use Orchid\Defender\Utilities\Address\AddressInterface;

interface ExpressionInterface
{
    /**
     * check whether the expression matches an address
     *
     * @param  AddressInterface $address
     * @return boolean
     */
    public function matches(AddressInterface $address);
}