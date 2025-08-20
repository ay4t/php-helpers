<?php

namespace Ay4t\Helper\Tests\Validation;

use Ay4t\Helper\Validation\ShippingContainerChecker;
use Ay4t\Helper\HP;
use PHPUnit\Framework\TestCase;

class ShippingContainerCheckerTest extends TestCase
{
    public function testCalculateCheckDigitFromParts()
    {
        $checker = new ShippingContainerChecker();
        $checker->set('CSQU305438'); // tanpa check digit
        $this->assertSame(3, $checker->calculateCheckDigit());
    }

    public function testValidateFullNumber()
    {
        $checker = new ShippingContainerChecker();
        $checker->set('CSQU3054383');
        $this->assertTrue($checker->isValid());
        $this->assertSame('CSQU3054383', $checker->getResult());
    }

    public function testInvalidNumber()
    {
        $checker = new ShippingContainerChecker();
        $checker->set('CSQU3054384'); // seharusnya 3, bukan 4
        $this->assertFalse($checker->isValid());
        $this->assertSame('CSQU3054383', $checker->getResult());
    }

    public function testSetFlexibleInput()
    {
        $checker = new ShippingContainerChecker();
        $checker->set('CSQU 305438 3');
        $this->assertTrue($checker->isValid());
        $this->assertSame(3, $checker->expectedCheckDigit());
    }

    public function testFacadeHP()
    {
        // Bisa dipanggil via HP facade
        $hp = HP::ShippingContainerChecker('CSQU3054383');
        $this->assertTrue($hp->isValid());
        $this->assertSame('CSQU3054383', $hp->getResult());
    }
}
