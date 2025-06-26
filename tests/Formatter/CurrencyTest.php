<?php

namespace Ay4t\Helper\Tests\Formatter;

use Ay4t\Helper\Formatter\Currency;
use PHPUnit\Framework\TestCase;

class CurrencyTest extends TestCase
{
    private $currencyHelper;

    protected function setUp(): void
    {
        $this->currencyHelper = new Currency();
    }

    public function testFormatIDR()
    {
        $formatted = $this->currencyHelper->set(1500000, 'IDR', 2)->getResult();
        // Note: The currency symbol might vary based on the ICU version.
        // We check for the presence of the numeric part and the currency code.
        $this->assertStringContainsString('1,500,000.00', $formatted);
        $this->assertStringContainsString('IDR', $formatted);
    }

    public function testFormatUSD()
    {
        $formatted = $this->currencyHelper->set(250.75, 'USD', 2)->getResult();
        $this->assertStringContainsString('250.75', $formatted);
        $this->assertStringContainsString('$', $formatted);
    }

    public function testFormatWithoutDecimal()
    {
        $formatted = $this->currencyHelper->set(50000, 'IDR', 0)->getResult();
        $this->assertStringContainsString('50,000', $formatted);
        $this->assertStringNotContainsString('.', $formatted);
    }

    public function testCountedIDR()
    {
        $counted = $this->currencyHelper->set(12345)->counted();
        $this->assertEquals('dua belas ribu tiga ratus empat puluh lima', $counted);
    }

    public function testCountedWithGetResult()
    {
        $this->currencyHelper->set(999);
        $counted = $this->currencyHelper->counted();
        $this->assertEquals('sembilan ratus sembilan puluh sembilan', $counted);

        // After calling counted(), getResult() should return the counted text.
        $result = $this->currencyHelper->getResult();
        $this->assertEquals($counted, $result);
    }
}
