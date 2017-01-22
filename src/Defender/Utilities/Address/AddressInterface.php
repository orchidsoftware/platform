<?php namespace Orchid\Defender\Utilities\Address;

use Orchid\Defender\Utilities\Expression\ExpressionInterface;

interface AddressInterface
{
    /**
     * get fully expanded address
     *
     * @return string
     */
    public function getExpanded();

    /**
     * get compact address representation
     *
     * @return string
     */
    public function getCompact();

    /**
     * get IP-specific chunks ([127,000,000,001] for IPv4 or [0000,0000,00ff,00ea,0001,...] for IPv6)
     *
     * @return array
     */
    public function getChunks();

    /**
     * check whether the address matches a given pattern/range
     *
     * @param  ExpressionInterface $expression
     * @return boolean
     */
    public function matches(ExpressionInterface $expression);
}