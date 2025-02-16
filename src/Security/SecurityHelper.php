<?php

namespace Ay4t\Helper\Security;

/**
 * Security Helper Class
 * Provides various security-related functionalities
 * 
 * @package Ay4t\Helper\Security
 * @author Ayatulloh Ahad R
 */
class SecurityHelper implements \Ay4t\Helper\Interface\FormatterInterface
{
    /** @var mixed */
    private $data;

    /** @var array */
    private $options = [
        'hash_algo' => PASSWORD_ARGON2ID,
        'hash_options' => [],
        'token_length' => 32
    ];

    /**
     * Set the data to be processed
     * 
     * @param mixed $data
     * @return self
     */
    public function set($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Hash a password securely
     * 
     * @param array $options Additional password_hash options
     * @return string
     */
    public function hashPassword(array $options = []): string
    {
        $options = array_merge($this->options['hash_options'], $options);
        return password_hash($this->data, $this->options['hash_algo'], $options);
    }

    /**
     * Verify a password against a hash
     * 
     * @param string $hash The hash to verify against
     * @return bool
     */
    public function verifyPassword(string $hash): bool
    {
        return password_verify($this->data, $hash);
    }

    /**
     * Generate a secure random token
     * 
     * @param int $length Length of the token
     * @param bool $urlSafe Whether to make the token URL-safe
     * @return string
     */
    public function generateToken(int $length = 32, bool $urlSafe = true): string
    {
        $bytes = random_bytes($length);
        
        if ($urlSafe) {
            return rtrim(strtr(base64_encode($bytes), '+/', '-_'), '=');
        }
        
        return bin2hex($bytes);
    }

    /**
     * Generate a secure API key
     * 
     * @param string $prefix Optional prefix for the key
     * @return string
     */
    public function generateApiKey(string $prefix = ''): string
    {
        $token = $this->generateToken(32);
        return $prefix ? $prefix . '_' . $token : $token;
    }

    /**
     * Encrypt data using OpenSSL
     * 
     * @param string $key Encryption key
     * @param string $method Encryption method
     * @return string|false
     */
    public function encrypt(string $key, string $method = 'aes-256-cbc')
    {
        $ivlen = openssl_cipher_iv_length($method);
        $iv = openssl_random_pseudo_bytes($ivlen);
        
        $encrypted = openssl_encrypt(
            $this->data,
            $method,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );

        if ($encrypted === false) {
            return false;
        }

        // Prepend IV to encrypted data
        return base64_encode($iv . $encrypted);
    }

    /**
     * Decrypt data using OpenSSL
     * 
     * @param string $key Decryption key
     * @param string $method Encryption method
     * @return string|false
     */
    public function decrypt(string $key, string $method = 'aes-256-cbc')
    {
        $data = base64_decode($this->data);
        $ivlen = openssl_cipher_iv_length($method);
        
        $iv = substr($data, 0, $ivlen);
        $encrypted = substr($data, $ivlen);

        return openssl_decrypt(
            $encrypted,
            $method,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );
    }

    /**
     * Generate a CSRF token
     * 
     * @return string
     */
    public function generateCsrfToken(): string
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = $this->generateToken();
        }

        return $_SESSION['csrf_token'];
    }

    /**
     * Verify a CSRF token
     * 
     * @param string $token Token to verify
     * @return bool
     */
    public function verifyCsrfToken(string $token): bool
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        return hash_equals($_SESSION['csrf_token'] ?? '', $token);
    }

    /**
     * Generate a secure random password
     * 
     * @param int $length Password length
     * @param bool $special Include special characters
     * @param bool $extra Include extra special characters
     * @return string
     */
    public function generatePassword(int $length = 12, bool $special = true, bool $extra = false): string
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        
        if ($special) {
            $chars .= '!@#$%^&*()';
        }
        
        if ($extra) {
            $chars .= '-_ []{}<>~+=,.;:/?|';
        }

        $password = '';
        $max = strlen($chars) - 1;

        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[random_int(0, $max)];
        }

        return $password;
    }

    /**
     * Hash data using specified algorithm
     * 
     * @param string $algo Hash algorithm
     * @param bool $raw_output Whether to output raw binary data
     * @return string
     */
    public function hash(string $algo = 'sha256', bool $raw_output = false): string
    {
        return hash($algo, $this->data, $raw_output);
    }

    /**
     * Generate HMAC
     * 
     * @param string $key Secret key
     * @param string $algo Hash algorithm
     * @return string
     */
    public function hmac(string $key, string $algo = 'sha256'): string
    {
        return hash_hmac($algo, $this->data, $key);
    }
}
