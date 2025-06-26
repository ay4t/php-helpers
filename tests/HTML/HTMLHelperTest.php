<?php

namespace Ay4t\Helper\Tests\HTML;

use Ay4t\Helper\HTML\HTMLHelper;
use PHPUnit\Framework\TestCase;

class HTMLHelperTest extends TestCase
{
    private $htmlHelper;

    protected function setUp(): void
    {
        $this->htmlHelper = new HTMLHelper();
    }

    public function testElement()
    {
        $this->assertEquals('<p>Hello</p>', $this->htmlHelper->element('p', [], 'Hello'));
    }

    public function testElementWithAttributes()
    {
        $this->assertEquals('<div class="container">Content</div>', $this->htmlHelper->element('div', ['class' => 'container'], 'Content'));
    }

    public function testVoidElement()
    {
        $this->assertEquals('<img src="image.jpg" alt="An image">', $this->htmlHelper->image('image.jpg', 'An image'));
    }

    public function testLink()
    {
        $this->assertEquals('<a href="https://example.com">Example</a>', $this->htmlHelper->link('https://example.com', 'Example'));
    }

    public function testSelect()
    {
        $options = ['a' => 'Apple', 'b' => 'Banana'];
        $expected = '<select name="fruit"><option value="a">Apple</option><option value="b" selected="selected">Banana</option></select>';
        $this->assertEquals($expected, $this->htmlHelper->select('fruit', $options, 'b'));
    }

    public function testTable()
    {
        $headers = ['ID', 'Name'];
        $data = [['1', 'John'], ['2', 'Jane']];
        $expected = '<table><thead><tr><th>ID</th><th>Name</th></tr></thead><tbody><tr><td>1</td><td>John</td></tr><tr><td>2</td><td>Jane</td></tr></tbody></table>';
        $this->assertEquals($expected, $this->htmlHelper->table($data, $headers));
    }

    public function testEscape()
    {
        $this->assertEquals('&lt;script&gt;alert(&quot;XSS&quot;);&lt;/script&gt;', $this->htmlHelper->escape('<script>alert("XSS");</script>'));
    }

    public function testGetResult()
    {
        $this->htmlHelper->set('test content');
        $this->assertEquals('test content', $this->htmlHelper->getResult());
    }
}
