<?php

namespace Ay4t\Helper\Tests\Validation;

use Ay4t\Helper\Validation\ValidationHelper;
use PHPUnit\Framework\TestCase;

class ValidationHelperTest extends TestCase
{
    private $validationHelper;

    protected function setUp(): void
    {
        $this->validationHelper = new ValidationHelper();
    }

    public function testIsEmail()
    {
        $this->assertTrue($this->validationHelper->set('test@example.com')->isEmail());
        $this->assertFalse($this->validationHelper->set('invalid-email')->isEmail());
    }

    public function testIsUrl()
    {
        $this->assertTrue($this->validationHelper->set('https://example.com')->isUrl());
        $this->assertFalse($this->validationHelper->set('not a url')->isUrl());
    }

    public function testValidate()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'age' => 25
        ];

        $rules = [
            'name' => ['required', 'length' => [2, 50]],
            'email' => ['required', 'email'],
            'age' => ['required', 'numeric', 'min' => 18]
        ];

        $this->assertTrue($this->validationHelper->validate($data, $rules));
        $this->assertEmpty($this->validationHelper->getErrors());
    }

    public function testValidateFails()
    {
        $data = [
            'name' => 'J',
            'email' => 'invalid',
            'age' => 17
        ];

        $rules = [
            'name' => ['required', 'length' => [2, 50]],
            'email' => ['required', 'email'],
            'age' => ['required', 'numeric', 'min' => 18]
        ];

        $this->assertFalse($this->validationHelper->validate($data, $rules));
        $errors = $this->validationHelper->getErrors();
        $this->assertCount(3, $errors);
        $this->assertArrayHasKey('name', $errors);
        $this->assertArrayHasKey('email', $errors);
        $this->assertArrayHasKey('age', $errors);
    }

    public function testGetResult()
    {
        $this->validationHelper->set('test data');
        $this->assertEquals('test data', $this->validationHelper->getResult());
    }
}
