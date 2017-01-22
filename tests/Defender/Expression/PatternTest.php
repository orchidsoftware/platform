<?php

namespace Expression;

use Orchid\Defender\Utilities\Address\IPv4;
use Orchid\Defender\Utilities\Address\IPv6;
use Orchid\Defender\Utilities\Expression\Pattern;

class PatternTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider  addressProvider
     *
     * @param $pattern
     * @param $address
     * @param $expected
     */
    public function testMatches($pattern, $address, $expected)
    {
        $pattern = new Pattern($pattern);

        $this->assertSame($expected, $address->matches($pattern));
        $this->assertSame($expected, $pattern->matches($address));
    }

    /**
     * @return array
     */
    public function addressProvider()
    {
        return [
            ['0.0.0.0', new IPv4('0.0.0.0'), true],
            ['0.0.0.*', new IPv4('0.0.0.0'), true],
            ['0.0.0.**', new IPv4('0.0.0.0'), true],
            ['0.0.0.*****', new IPv4('0.0.0.0'), true],
            ['0.0.*.*', new IPv4('0.0.0.0'), true],
            ['0.0.*.*', new IPv4('0.0.0.1'), true],
            ['0.0.*.*', new IPv4('0.0.1.0'), true],
            ['0.0.*.*', new IPv4('0.0.12.13'), true],
            ['0.0.*.*', new IPv4('0.0.0.255'), true],
            ['0.0.*.*', new IPv4('0.5.0.255'), false],
            ['0.0.*.*', new IPv4('255.5.0.255'), false],
            ['0.0.*7.0', new IPv4('0.0.17.0'), true],
            ['0.0.*7.0', new IPv4('0.0.117.0'), true],
            ['0.0.*7*.0', new IPv4('0.0.17.0'), false],
            ['0.0.*7**.0', new IPv4('0.0.17.0'), false],
            ['0.0.1**.0', new IPv4('0.0.1.0'), false],
            ['0.0.1**.0', new IPv4('0.0.17.0'), true],
            ['0.0.1**.0', new IPv4('0.0.174.0'), true],
            ['0.0.1**.0', new IPv4('0.0.41.0'), false],
            ['0.0.1**.0', new IPv4('0.0.211.0'), false],
            ['0.0.1**1.0', new IPv4('0.0.121.0'), true],
            ['0.0.1**1.0', new IPv4('0.0.11.0'), false],
            ['0.0.1**1.0', new IPv4('0.0.122.0'), false],
            ['0.0.*.255', new IPv4('0.0.0.255'), true],
            ['0.0.*.255', new IPv4('0.0.0.255'), true],
            ['0.0.0.1*1', new IPv4('0.0.0.101'), true],
            ['0.0.0.1*1', new IPv4('0.0.0.11'), false],
            ['0.0.0.1*1', new IPv4('0.0.0.110'), false],
            ['0.0.0.1*1', new IPv4('0.0.0.1'), false],

            ['2001:db8:85a3:0:0:8a2e:370:7334', new IPv6('2001:db8:85a3::8a2e:370:7334'), true],
            ['2001:db8:85a3:0:0:*:370:7334', new IPv6('2001:db8:85a3::8a2e:370:7334'), true],
            ['2001:db8:8*a3:0:0:8a*e:370:7334', new IPv6('2001:db8:85a3::8a2e:370:7334'), true],
            ['2001:**:8*a3:0:0:8a*e:370:7334', new IPv6('2001:db8:85a3::8a2e:370:7334'), true],
            ['2001:**:8*a3:0:0:8a*e:370:*3*4', new IPv6('2001:db8:85a3::8a2e:370:7334'), true],

            ['2001:db8:85a3:0:0:9*:370:7334', new IPv6('2001:db8:85a3::8a2e:370:7334'), false],
            ['2001:db8:85a3:0:0:8a2e:370*:7334', new IPv6('2001:db8:85a3::8a2e:370:7334'), false],
            ['2001:db8:*85a3:0:0:8a2e:370:7334', new IPv6('2001:db8:85a3::8a2e:370:7334'), false],
            ['2001:d*b8:85a3:0:0:8a2e:370:7334', new IPv6('2001:db8:85a3::8a2e:370:7334'), false],
        ];
    }
}
