<?php

namespace Ay4t\Helper\Tests\String;

use Ay4t\Helper\String\StringHelper;
use PHPUnit\Framework\TestCase;

class StringHelperTest extends TestCase
{
    private $stringHelper;

    protected function setUp(): void
    {
        $this->stringHelper = new StringHelper();
    }

    public function testSlugify()
    {
        $string = 'Hello World! This is a test.';
        $slug = $this->stringHelper->set($string)->slugify();
        $this->assertEquals('hello-world-this-is-a-test', $slug);

        $string = '  leading and trailing spaces  ';
        $slug = $this->stringHelper->set($string)->slugify();
        $this->assertEquals('leading-and-trailing-spaces', $slug);

        $string = 'Jïñgã Fôõ Bãr';
        $slug = $this->stringHelper->set($string)->slugify();
        $this->assertEquals('jinga-foo-bar', $slug);
    }

    public function testTruncate()
    {
        $string = 'This is a long string that needs to be truncated.';
        $truncated = $this->stringHelper->set($string)->truncate(20);
        $this->assertEquals('This is a long...', $truncated);

        $truncated = $this->stringHelper->set($string)->truncate(20, '---', false);
        $this->assertEquals('This is a long strin---', $truncated);
        
        $shortString = 'Short';
        $truncated = $this->stringHelper->set($shortString)->truncate(10);
        $this->assertEquals('Short', $truncated);
    }

    public function testExcerpt()
    {
        $html = '<p>This is some <b>bold</b> text.</p> Here is more.';
        $excerpt = $this->stringHelper->set($html)->excerpt(20);
        $this->assertEquals('This is some bold...', $excerpt);
    }

    public function testHumanize()
    {
        $string = 'hello_world-test';
        $humanized = $this->stringHelper->set($string)->humanize();
        $this->assertEquals('Hello World Test', $humanized);
    }

    public function testMask()
    {
        $string = '1234567890';
        $masked = $this->stringHelper->set($string)->mask(4, 4);
        $this->assertEquals('1234****90', $masked);

        $masked = $this->stringHelper->set($string)->mask(0, 6, '#');
        $this->assertEquals('######7890', $masked);

        $masked = $this->stringHelper->set($string)->mask(6);
        $this->assertEquals('123456****', $masked);
    }

    public function testToSnakeCase()
    {
        $string = 'helloWorldTest';
        $snake = $this->stringHelper->set($string)->toSnakeCase();
        $this->assertEquals('hello_world_test', $snake);
    }

    public function testToCamelCase()
    {
        $string = 'hello_world_test';
        $camel = $this->stringHelper->set($string)->toCamelCase();
        $this->assertEquals('helloWorldTest', $camel);

        $camel = $this->stringHelper->set($string)->toCamelCase(true);
        $this->assertEquals('HelloWorldTest', $camel);
    }

    public function testRemoveWhitespace()
    {
        $string = '  Hello   World  ';
        $noSpace = $this->stringHelper->set($string)->removeWhitespace();
        $this->assertEquals('HelloWorld', $noSpace);
    }

    public function testExtractEmails()
    {
        $string = 'Contact us at test@example.com or support@example.org.';
        $emails = $this->stringHelper->set($string)->extractEmails();
        $this->assertEquals(['test@example.com', 'support@example.org'], $emails);

        $string = 'No emails here.';
        $emails = $this->stringHelper->set($string)->extractEmails();
        $this->assertEquals([], $emails);
    }

    public function testToTitleCase()
    {
        $string = 'a tale of two cities';
        $title = $this->stringHelper->set($string)->toTitleCase();
        $this->assertEquals('A Tale of Two Cities', $title);

        $string = 'the quick brown fox';
        $title = $this->stringHelper->set($string)->toTitleCase();
        $this->assertEquals('The Quick Brown Fox', $title);
    }

    public function testInitials()
    {
        $string = 'John Fitzgerald Kennedy';
        $initials = $this->stringHelper->set($string)->initials(2);
        $this->assertEquals('JF', $initials);

        $initials = $this->stringHelper->set($string)->initials(3);
        $this->assertEquals('JFK', $initials);
    }

    public function testGetResult()
    {
        $string = 'This is a test string.';
        $this->stringHelper->set($string);
        $this->assertEquals($string, $this->stringHelper->getResult());
    }

    public function testToBoolean_BooleanStrings()
    {
        $this->assertTrue($this->stringHelper->set('true')->toBoolean());
        $this->assertFalse($this->stringHelper->set('false')->toBoolean());
        $this->assertTrue($this->stringHelper->set('TRUE')->toBoolean());
        $this->assertFalse($this->stringHelper->set('FALSE')->toBoolean());
    }

    public function testToBoolean_YesNo_OnOff_TF_YN()
    {
        $this->assertTrue($this->stringHelper->set('yes')->toBoolean());
        $this->assertFalse($this->stringHelper->set('no')->toBoolean());
        $this->assertTrue($this->stringHelper->set('on')->toBoolean());
        $this->assertFalse($this->stringHelper->set('off')->toBoolean());

        $this->assertTrue($this->stringHelper->set('t')->toBoolean());
        $this->assertFalse($this->stringHelper->set('f')->toBoolean());
        $this->assertTrue($this->stringHelper->set('y')->toBoolean());
        $this->assertFalse($this->stringHelper->set('n')->toBoolean());
    }

    public function testToBoolean_Numeric()
    {
        $this->assertTrue($this->stringHelper->set('1')->toBoolean());
        $this->assertFalse($this->stringHelper->set('0')->toBoolean());
        $this->assertTrue($this->stringHelper->set('42')->toBoolean());
        $this->assertTrue($this->stringHelper->set('-1')->toBoolean());
        $this->assertFalse($this->stringHelper->set('0.0')->toBoolean());
        $this->assertTrue($this->stringHelper->set('0.1')->toBoolean());
    }

    public function testToBoolean_DefaultFallback()
    {
        $this->assertTrue($this->stringHelper->set('maybe')->toBoolean(true));
        $this->assertFalse($this->stringHelper->set('maybe')->toBoolean(false));
        // Tanpa default -> fallback false
        $this->assertFalse($this->stringHelper->set('maybe')->toBoolean());
    }

    public function testToBoolean_MethodChaining()
    {
        // Pastikan set()->toBoolean() bekerja berurutan untuk nilai berbeda
        $this->assertTrue($this->stringHelper->set('true')->toBoolean());
        $this->assertFalse($this->stringHelper->set('false')->toBoolean());
        $this->assertTrue($this->stringHelper->set('yes')->toBoolean());
        $this->assertFalse($this->stringHelper->set('no')->toBoolean());
    }
}
