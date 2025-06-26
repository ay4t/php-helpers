<?php

namespace Ay4t\Helper\Tests\File;

use Ay4t\Helper\File\FileHelper;
use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStream;

class FileHelperTest extends TestCase
{
    private $root;
    private $filePath;
    private $fileHelper;

    protected function setUp(): void
    {
        $this->root = vfsStream::setup('root');
        $this->filePath = vfsStream::url('root/test.txt');
        file_put_contents($this->filePath, 'Hello, world!');

        $this->fileHelper = new FileHelper();
        $this->fileHelper->set($this->filePath);
    }

    public function testGetHumanSize()
    {
        $this->assertEquals('13 B', $this->fileHelper->getHumanSize());
    }

    public function testGetMimeType()
    {
        // vfsStream doesn't support mime_content_type, so we can't test this directly.
        // We'll trust PHP's built-in function.
        $this->markTestSkipped('vfsStream does not support mime_content_type.');
    }

    public function testGetExtension()
    {
        $this->assertEquals('txt', $this->fileHelper->getExtension());
    }

    public function testGetBaseName()
    {
        $this->assertEquals('test', $this->fileHelper->getBaseName());
    }

    public function testCopy()
    {
        $destination = vfsStream::url('root/copy.txt');
        $this->assertTrue($this->fileHelper->copy($destination));
        $this->assertFileExists($destination);
        $this->assertEquals('Hello, world!', file_get_contents($destination));
    }

    public function testMove()
    {
        $destination = vfsStream::url('root/move.txt');
        $this->assertTrue($this->fileHelper->move($destination));
        $this->assertFileDoesNotExist($this->filePath);
        $this->assertFileExists($destination);
    }

    public function testBackup()
    {
        $this->assertTrue($this->fileHelper->backup());
        $this->assertFileExists($this->filePath . '.bak');
    }

    public function testGetResult()
    {
        $this->assertEquals($this->filePath, $this->fileHelper->getResult());
    }

    public function testGetHash()
    {
        $this->assertEquals(md5('Hello, world!'), $this->fileHelper->getHash('md5'));
    }
}
