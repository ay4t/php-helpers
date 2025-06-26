<?php

namespace Ay4t\Helper\Tests\URL;

use Ay4t\Helper\URL\URLHelper;
use PHPUnit\Framework\TestCase;

class URLHelperTest extends TestCase
{
    private $urlHelper;

    protected function setUp(): void
    {
        $this->urlHelper = new URLHelper();
    }

    public function testAddQueryParams()
    {
        $url = 'https://example.com/path';
        $newUrl = $this->urlHelper->set($url)->addQueryParams(['a' => 1, 'b' => 2]);
        $this->assertEquals('https://example.com/path?a=1&b=2', $newUrl);
    }

    public function testRemoveQueryParams()
    {
        $url = 'https://example.com/path?a=1&b=2&c=3';
        $newUrl = $this->urlHelper->set($url)->removeQueryParams(['b', 'c']);
        $this->assertEquals('https://example.com/path?a=1', $newUrl);
    }

    public function testMakeAbsolute()
    {
        $baseUrl = 'https://example.com/base/';
        $relativeUrl = 'path/to/page.html';
        $absoluteUrl = $this->urlHelper->set($relativeUrl)->makeAbsolute($baseUrl);
        $this->assertEquals('https://example.com/base/path/to/page.html', $absoluteUrl);
    }

    public function testBuildUrl()
    {
        $components = [
            'scheme' => 'https',
            'host' => 'example.com',
            'path' => '/test',
            'query' => 'id=123'
        ];
        $url = $this->urlHelper->buildUrl($components);
        $this->assertEquals('https://example.com/test?id=123', $url);
    }

    public function testGetResult()
    {
        $url = 'https://example.com';
        $this->urlHelper->set($url);
        $this->assertEquals($url, $this->urlHelper->getResult());
    }
}
