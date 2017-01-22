<?php


use Orchid\Defender\Utilities\Address\IPv4;
use Orchid\Defender\Utilities\Address\IPv6;
use Orchid\Defender\Utilities\Factory;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider  validAddressProvider
     * @param $address
     * @param $expected
     */
    public function testGetAddress($address, $expected)
    {
        $address = Factory::getAddress($address);
        $this->assertInstanceOf($expected, $address);
    }

    /**
     * @return array
     */
    public function validAddressProvider()
    {
        $v4 = 'IpUtils\Address\IPv4';
        $v6 = 'IpUtils\Address\IPv6';

        return [
            ['0.0.0.0', $v4],
            ['127.0.0.1', $v4],
            ['::1', $v6],
            ['fe80::', $v6]
        ];
    }

    /**
     * @dataProvider       invalidAddressProvider
     * @expectedException  UnexpectedValueException
     * @param $address
     */
    public function testGetInvalidAddress($address)
    {
        Factory::getAddress($address);
    }

    public function invalidAddressProvider()
    {
        return [
            ['0.0.0.300'],
            ['abc'],
            [':hallo:welt::']
        ];
    }

    /**
     * @dataProvider  expressionProvider
     * @param $expr
     * @param $expected
     */
    public function testGetExpression($expr, $expected)
    {
        $expr = Factory::getExpression($expr);
        $this->assertInstanceOf($expected, $expr);
    }

    /**
     * @return array
     */
    public function expressionProvider()
    {
        $literal = 'IpUtils\Expression\Literal';
        $pattern = 'IpUtils\Expression\Pattern';
        $subnet = 'IpUtils\Expression\Subnet';

        return [
            ['0.0.0.0', $literal],
            ['::1', $literal],
            ['fe80::1', $literal],

            ['0.0.0.0/8', $subnet],
            ['::1/8', $subnet],
            ['fe80::/128', $subnet],

            ['fe*::', $pattern],
            ['::1:*', $pattern],
            ['127.*.*.0', $pattern]
        ];
    }
}