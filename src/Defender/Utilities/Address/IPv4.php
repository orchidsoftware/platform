<?php

namespace Orchid\Defender\Utilities\Address;

use Orchid\Defender\Utilities\Expression\ExpressionInterface;
use Orchid\Defender\Utilities\Expression\Subnet;

class IPv4 implements AddressInterface
{
    protected $address;

    public function __construct($address)
    {
        if (!self::isValid($address)) {
            throw new \UnexpectedValueException('"'.$address.'" is no valid IPv4 address.');
        }

        $this->address = $address;
    }

    /**
     * @param $address
     *
     * @return bool
     *
     * @internal param string $addr
     */
    public static function isValid($address)
    {
        return filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
    }

    /**
     * @param int $netmask
     *
     * @return bool
     */
    public static function isValidNetmask($netmask)
    {
        return $netmask >= 1 && $netmask <= 32;
    }

    /**
     * @return IPv4
     */
    public static function getLoopback()
    {
        return new self('127.0.0.1');
    }

    /**
     * get IP-specific chunks ([127,0,0,1]).
     *
     * @return array
     */
    public function getChunks()
    {
        return explode('.', $this->getExpanded());
    }

    /**
     * get fully expanded address.
     *
     * @return string
     */
    public function getExpanded()
    {
        return $this->address;
    }

    /**
     * returns the compact representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getCompact();
    }

    /**
     * get compact address representation.
     *
     * @return string
     */
    public function getCompact()
    {
        return $this->getExpanded();
    }

    /**
     * check whether the IP points to the loopback (localhost) device.
     *
     * @return bool
     */
    public function isLoopback()
    {
        return $this->matches(new Subnet('127.0.0.0/8'));
    }

    /**
     * check whether the address matches a given pattern/range.
     *
     * @param ExpressionInterface $expression
     *
     * @return bool
     */
    public function matches(ExpressionInterface $expression)
    {
        return $expression->matches($this);
    }

    /**
     * check whether the IP is inside a private network.
     *
     * @return bool
     */
    public function isPrivate()
    {
        return
            $this->matches(new Subnet('10.0.0.0/8')) ||
            $this->matches(new Subnet('172.16.0.0/12')) ||
            $this->matches(new Subnet('192.168.0.0/16'));
    }

    /**
     * check whether the IP is a multicast address.
     */
    public function isMulticast()
    {
        return $this->matches(new Subnet('224.0.0.0/4'));
    }

    /**
     * check whether the IP is a link-local address.
     *
     * @return bool
     */
    public function isLinkLocal()
    {
        return $this->matches(new Subnet('169.254.1.0/24'));
    }
}
