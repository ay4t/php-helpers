<?php

namespace Ay4t\Helper\Tests\Formatter;

use Ay4t\Helper\Formatter\Phone;
use PHPUnit\Framework\TestCase;

class PhoneTest extends TestCase
{
    private $phoneHelper;

    protected function setUp(): void
    {
        $this->phoneHelper = new Phone();
    }

    public function testFormatInternational()
    {
        $formatted = $this->phoneHelper->set('081234567890', 'ID')->getResult();
        $this->assertEquals('+62 812-3456-7890', $formatted);
    }

    public function testFormatUSNumber()
    {
        $formatted = $this->phoneHelper->set('202-555-0104', 'US')->getResult();
        $this->assertEquals('+1 202-555-0104', $formatted);
    }

    public function testFormatOnlyInteger()
    {
        $this->phoneHelper->onlyInteger(true);
        $formatted = $this->phoneHelper->set('0812-3456-7890', 'ID')->getResult();
        $this->assertEquals('6281234567890', $formatted);
    }

    public function testInvalidNumber()
    {
        $this->expectException(\libphonenumber\NumberParseException::class);
        $this->phoneHelper->set('not a phone number', 'ID')->getResult();
    }
    
    public function testChainingOnlyInteger()
    {
        $phone = new Phone();
        $phone->set('081234567890', 'ID');
        $phone->onlyInteger(true);
        $formatted = $phone->getResult();
        $this->assertEquals('6281234567890', $formatted);
    }
}
