<?php

namespace Ay4t\Helper\Tests\Formatter;

use Ay4t\Helper\Formatter\Datetime;
use PHPUnit\Framework\TestCase;

class DatetimeTest extends TestCase
{
    public function testCanBeInstantiated()
    {
        $datetime = new Datetime('2023-01-01 12:00:00');
        $this->assertInstanceOf(Datetime::class, $datetime);
        $this->assertInstanceOf(\Carbon\Carbon::class, $datetime);
    }

    public function testCanUseCarbonMethods()
    {
        $datetime = new Datetime('2023-01-01');
        $this->assertEquals('2023-01-02', $datetime->addDay()->toDateString());
    }

    public function testCanBeUsedStatically()
    {
        $now = Datetime::now();
        $this->assertInstanceOf(Datetime::class, $now);
    }
}
