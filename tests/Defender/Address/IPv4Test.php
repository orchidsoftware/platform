<?php namespace Address;

use Orchid\Defender\Utilities\Address\IPv4;
use Orchid\Defender\Utilities\Factory;

class IPv4Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider  addressProvider
     * @param $address
     * @param $expected
     */
    public function testIsValid($address, $expected)
    {
        $this->assertEquals($expected, IPv4::isValid($address));

        try {
            $addr = new IPv4($address);

            if ($expected === false) {
                $this->fail('Constructor should fail if invalid IP was given.');
            }
        } catch (\UnexpectedValueException $e) {
            if ($expected === true) {
                $this->fail('Constructor should not have thrown up.');
            }
        }
    }

    public function addressProvider()
    {
        return [
            ['0.0.0.0', true],
            ['127.0.0.1', true],

            ['127.0.0.300', false],
            ['127.0.000.1', false],
            ['127.0. 0.1', false],
            ['127. ', false],
            ['', false],
            ['::1', false],
            ['1.1.1.1/8', false],
            ['1.-.1.1', false]
        ];
    }

    public function testGetExpanded()
    {
        $addr = new IPv4('127.0.0.1');
        $this->assertSame('127.0.0.1', $addr->getExpanded());
    }

    public function testGetCompact()
    {
        $addr = new IPv4('127.0.0.1');
        $this->assertSame('127.0.0.1', $addr->getCompact());
    }

    public function testToString()
    {
        $addr = new IPv4('127.0.0.1');
        $this->assertSame('127.0.0.1', (string)$addr);
    }

    /**
     * @dataProvider  loopbackProvider
     * @param $address
     * @param $expected
     */
    public function testIsLoopback($address, $expected)
    {
        $address = new IPv4($address);
        $this->assertSame($expected, $address->isLoopback());
    }

    public function loopbackProvider()
    {
        return [
            ['127.0.0.1', true],
            ['127.0.0.2', true],
            ['127.0.1.0', true],
            ['128.0.0.1', false]
        ];
    }

    /**
     * @dataProvider  chunkProvider
     * @param $address
     * @param array $chunks
     */
    public function testGetChunks($address, array $chunks)
    {
        $addr = new IPv4($address);
        $this->assertSame($chunks, $addr->getChunks());
    }

    public function chunkProvider()
    {
        return [
            ['0.0.0.0', ['0', '0', '0', '0']],
            ['127.0.0.1', ['127', '0', '0', '1']]
        ];
    }

    /**
     * @dataProvider  privateProvider
     * @param $address
     * @param $expected
     */
    public function testIsPrivate($address, $expected)
    {
        $addr = new IPv4($address);
        $this->assertSame($expected, $addr->isPrivate());
    }

    public function privateProvider()
    {
        return [
            ['0.0.0.0', false],
            ['192.168.100.15', true],
            ['10.0.0.0', true],
            ['10.0.0.50', true],
            ['10.0.1.50', true],
            ['127.0.0.1', false],
            ['172.16.0.1', true],
            ['172.1.0.1', false]
        ];
    }

    public function testGetLoopback()
    {
        $this->assertTrue(IPv4::getLoopback()->isLoopback());
    }

    /**
     * @dataProvider  multicastProvider
     * @param $address
     * @param $expected
     */
    public function testIsMulticast($address, $expected)
    {
        $addr = new IPv4($address);
        $this->assertSame($expected, $addr->isMulticast());
    }

    public function multicastProvider()
    {
        return [
            ['224.0.0.1', true],
            ['220.0.0.2', false]
        ];
    }

    /**
     * @dataProvider  linkLocalProvider
     * @param $address
     * @param $expected
     */
    public function testIsLinkLocal($address, $expected)
    {
        $addr = new IPv4($address);
        $this->assertSame($expected, $addr->isLinkLocal());
    }

    public function linkLocalProvider()
    {
        return [
            ['169.254.1.1', true],
            ['169.255.1.1', false],
        ];
    }
}