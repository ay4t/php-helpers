<?php

namespace Ay4t\Helper\Tests\Security;

use Ay4t\Helper\Security\SecurityHelper;
use PHPUnit\Framework\TestCase;

class SecurityHelperTest extends TestCase
{
    private $securityHelper;

    protected function setUp(): void
    {
        $this->securityHelper = new SecurityHelper();
    }

    public function testPasswordHashingAndVerification()
    {
        $password = 'my-secret-password';
        $hash = $this->securityHelper->set($password)->hashPassword();

        $this->assertNotEmpty($hash);
        $this->assertTrue($this->securityHelper->set($password)->verifyPassword($hash));
        $this->assertFalse($this->securityHelper->set('wrong-password')->verifyPassword($hash));
    }

    public function testEncryptionAndDecryption()
    {
        $data = 'This is a secret message.';
        $key = 'a-very-secret-key';

        $encrypted = $this->securityHelper->set($data)->encrypt($key);
        $this->assertNotEquals($data, $encrypted);

        $decrypted = $this->securityHelper->set($encrypted)->decrypt($key);
        $this->assertEquals($data, $decrypted);
    }

    public function testGenerateToken()
    {
        // Test URL-safe token (default)
        $tokenUrlSafe = $this->securityHelper->generateToken(16, true);
        $this->assertTrue(is_string($tokenUrlSafe));

        // Test non-URL-safe token (hex)
        $tokenHex = $this->securityHelper->generateToken(16, false);
        $this->assertEquals(32, strlen($tokenHex));
        $this->assertTrue(ctype_xdigit($tokenHex));
    }

    public function testCsrfToken()
    {
        $csrf_storage = ''; // Start with an empty storage
        
        // Generate a token
        $token1 = $this->securityHelper->generateCsrfToken($csrf_storage);
        $this->assertNotEmpty($token1);
        $this->assertNotEmpty($csrf_storage);
        $this->assertEquals($token1, $csrf_storage);

        // Calling again should return the same token
        $token2 = $this->securityHelper->generateCsrfToken($csrf_storage);
        $this->assertEquals($token1, $token2);

        // Verification
        $this->assertTrue($this->securityHelper->verifyCsrfToken($token1, $csrf_storage));
        $this->assertFalse($this->securityHelper->verifyCsrfToken('invalid-token', $csrf_storage));
    }

    public function testGetResult()
    {
        $this->securityHelper->set('test data');
        $this->assertEquals('test data', $this->securityHelper->getResult());
    }
}
