<?php

namespace Ay4t\Helper\Tests;

use Ay4t\Helper\HP;
use Ay4t\Helper\Formatter\Currency;
use Ay4t\Helper\Formatter\Phone;
use Ay4t\Helper\String\StringHelper;
use Ay4t\Helper\File\FileHelper;
use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStream;

class HPTest extends TestCase
{
    public function testCanCallCurrencyHelper()
    {
        $currency = HP::Currency(1000, 'IDR');
        $this->assertInstanceOf(Currency::class, $currency);
        $this->assertStringContainsString('1,000', $currency->getResult());
    }

    public function testCanCallPhoneHelper()
    {
        $phone = HP::Phone('08123456789', 'ID');
        $this->assertInstanceOf(Phone::class, $phone);
        $this->assertEquals('+62 812-3456-789', $phone->getResult());
    }

    public function testCanCallStringHelper()
    {
        $string = HP::String('hello world');
        $this->assertInstanceOf(StringHelper::class, $string);
        $this->assertEquals('Hello World', $string->toTitleCase());
    }

    public function testCanCallFileHelper()
    {
        vfsStream::setup('root', null, ['test.txt' => 'content']);
        $file = HP::File(vfsStream::url('root/test.txt'));
        $this->assertInstanceOf(FileHelper::class, $file);
        $this->assertEquals('test', $file->getBaseName());
    }

    public function testThrowsExceptionForInvalidHelper()
    {
        $this->expectException(\BadMethodCallException::class);
        HP::NonExistentHelper('some', 'args');
    }
}
