<?php

namespace Ay4t\Helper\Tests\Formatter;

use Ay4t\Helper\Formatter\ArrayHelper;
use PHPUnit\Framework\TestCase;

class ArrayHelperTest extends TestCase
{
    private $arrayHelper;
    private $sampleArray;
    private $assocArray;

    protected function setUp(): void
    {
        $this->arrayHelper = new ArrayHelper();
        $this->sampleArray = [1, 2, [3, 4], 5];
        $this->assocArray = [
            ['id' => 1, 'name' => 'Alice', 'group' => 'A'],
            ['id' => 2, 'name' => 'Bob', 'group' => 'B'],
            ['id' => 3, 'name' => 'Charlie', 'group' => 'A'],
            ['id' => 4, 'name' => 'Bob', 'group' => 'C'],
        ];
    }

    public function testFlatten()
    {
        $flattened = $this->arrayHelper->set($this->sampleArray)->flatten();
        $this->assertEquals([1, 2, 3, 4, 5], $flattened);
    }

    public function testGroupBy()
    {
        $grouped = $this->arrayHelper->set($this->assocArray)->groupBy('group');
        $expected = [
            'A' => [
                ['id' => 1, 'name' => 'Alice', 'group' => 'A'],
                ['id' => 3, 'name' => 'Charlie', 'group' => 'A'],
            ],
            'B' => [
                ['id' => 2, 'name' => 'Bob', 'group' => 'B'],
            ],
            'C' => [
                ['id' => 4, 'name' => 'Bob', 'group' => 'C'],
            ],
        ];
        $this->assertEquals($expected, $grouped);
    }

    public function testPluck()
    {
        $plucked = $this->arrayHelper->set($this->assocArray)->pluck('name');
        $this->assertEquals(['Alice', 'Bob', 'Charlie', 'Bob'], $plucked);
    }

    public function testWhere()
    {
        $filtered = $this->arrayHelper->set($this->assocArray)->where('group', 'A');
        $expected = [
            ['id' => 1, 'name' => 'Alice', 'group' => 'A'],
            ['id' => 3, 'name' => 'Charlie', 'group' => 'A'],
        ];
        $this->assertEquals(array_values($expected), array_values($filtered));
    }

    public function testSortBy()
    {
        $sorted = $this->arrayHelper->set($this->assocArray)->sortBy('name');
        $expected = [
            ['id' => 1, 'name' => 'Alice', 'group' => 'A'],
            ['id' => 2, 'name' => 'Bob', 'group' => 'B'],
            ['id' => 4, 'name' => 'Bob', 'group' => 'C'],
            ['id' => 3, 'name' => 'Charlie', 'group' => 'A'],
        ];
        $this->assertEquals($expected, $sorted);

        $sortedDesc = $this->arrayHelper->set($this->assocArray)->sortBy('name', 'desc');
        $expectedDesc = [
            ['id' => 3, 'name' => 'Charlie', 'group' => 'A'],
            ['id' => 2, 'name' => 'Bob', 'group' => 'B'],
            ['id' => 4, 'name' => 'Bob', 'group' => 'C'],
            ['id' => 1, 'name' => 'Alice', 'group' => 'A'],
        ];
        $this->assertEquals($expectedDesc, $sortedDesc);
    }

    public function testUnique()
    {
        $array = [1, 2, 2, 3, 4, 4, 5];
        $unique = $this->arrayHelper->set($array)->unique();
        $this->assertEquals([1, 2, 3, 4, 5], array_values($unique));

        $uniqueByName = $this->arrayHelper->set($this->assocArray)->unique('name');
        $expected = [
            ['id' => 1, 'name' => 'Alice', 'group' => 'A'],
            ['id' => 2, 'name' => 'Bob', 'group' => 'B'],
            ['id' => 3, 'name' => 'Charlie', 'group' => 'A'],
        ];
        $this->assertEquals(array_values($expected), array_values($uniqueByName));
    }

    public function testChunk()
    {
        $array = [1, 2, 3, 4, 5];
        $chunked = $this->arrayHelper->set($array)->chunk(2);
        $this->assertEquals([[1, 2], [3, 4], [5]], $chunked);
    }

    public function testSearch()
    {
        $names = ['Alice', 'Bob', 'Charlie'];
        $result = $this->arrayHelper->set($names)->search('b');
        $this->assertEquals(['Bob'], array_values($result));

        $resultField = $this->arrayHelper->set($this->assocArray)->search('ali', 'name');
        $this->assertEquals([['id' => 1, 'name' => 'Alice', 'group' => 'A']], array_values($resultField));
    }

    public function testImplode()
    {
        $names = ['Alice', 'Bob', 'Charlie'];
        $imploded = $this->arrayHelper->set($names)->implode(', ');
        $this->assertEquals('Alice, Bob, Charlie', $imploded);

        $implodedField = $this->arrayHelper->set($this->assocArray)->implode(' - ', 'name');
        $this->assertEquals('Alice - Bob - Charlie - Bob', $implodedField);
    }

    public function testGetResult()
    {
        $this->arrayHelper->set($this->sampleArray);
        $this->assertEquals($this->sampleArray, $this->arrayHelper->getResult());
    }
}
