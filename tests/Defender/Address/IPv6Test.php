<?php namespace Address;

use Orchid\Defender\Utilities\Address\IPv6;
use Orchid\Defender\Utilities\Factory;

class IPv6Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider  addressProvider
     * @param $address
     * @param $expected
     */
    public function testIsValid($address, $expected)
    {
        $this->assertEquals($expected, IPv6::isValid($address));

        try {
            $addr = new IPv6($address);

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
            ['::1', true],
            ['feee::0:1', true],

            ['muh', false],
            ['muh::1', false],
            ['', false],
            ['1', false],
            ['1:', false],
            ['1:foo', false],
            ['1.1.1.1', false],
            ['::1/123', false],
            [': :1', false]
        ];
    }

    public function testGetExpanded()
    {
        $addr = new IPv6('::1');
        $this->assertSame('0000:0000:0000:0000:0000:0000:0000:0001', $addr->getExpanded());
    }

    public function testGetCompact()
    {
        $addr = new IPv6('0:0:0:0:0:0:0:1');
        $this->assertSame('::1', $addr->getCompact());
    }

    public function testToString()
    {
        $addr = new IPv6('0:0:0:0:0:0:0:1');
        $this->assertSame('::1', (string)$addr);
    }

    /**
     * @dataProvider  loopbackProvider
     * @param $address
     * @param $expected
     */
    public function testIsLoopback($address, $expected)
    {
        $address = new IPv6($address);
        $this->assertSame($expected, $address->isLoopback());
    }

    public function loopbackProvider()
    {
        return [
            ['0:0:0:0:0:0:0:1', true],
            ['::1', true],
            ['1::1', false],
            ['2a01:198:603:0::', false]
        ];
    }

    /**
     * @dataProvider  chunkProvider
     * @param $address
     * @param array $chunks
     */
    public function testGetChunks($address, array $chunks)
    {
        $addr = new IPv6($address);
        $this->assertSame($chunks, $addr->getChunks());
    }

    public function chunkProvider()
    {
        return [
            ['::1', ['0', '0', '0', '0', '0', '0', '0', '1']],
            ['2a01:198:603:0::', ['2a01', '198', '603', '0', '0', '0', '0', '0']]
        ];
    }

    /**
     * @dataProvider  privateProvider
     * @param $address
     * @param $expected
     */
    public function testIsPrivate($address, $expected)
    {
        $addr = new IPv6($address);
        $this->assertSame($expected, $addr->isPrivate());
    }

    public function privateProvider()
    {
        return [
            ['::1', false],
            ['fc00::', true],
            ['fc00::1', true],
            ['fd00::1', true],
            ['fc00:0:0:0:1::', true],
            ['fc00:0:beaf:0:1::', true],

            ['fbff::', false],
            ['fbff::ffff', false],
            ['fe01::beaf', false]
        ];
    }


    public function testGetLoopback()
    {
        $this->assertTrue(IPv6::getLoopback()->isLoopback());
    }
}