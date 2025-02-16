<?php

namespace Ay4t\Helper\Validation;

/**
 * Validation Helper Class
 * Provides methods for validating various types of data
 * 
 * @package Ay4t\Helper\Validation
 * @author Ayatulloh Ahad R
 */
class ValidationHelper implements \Ay4t\Helper\Interface\FormatterInterface
{
    /** @var mixed */
    private $data;

    /** @var array */
    private $errors = [];

    /** @var array */
    private $rules = [];

    /**
     * Set the data to be validated
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
     * Set validation rules
     * 
     * @param array $rules
     * @return self
     */
    public function rules(array $rules)
    {
        $this->rules = $rules;
        return $this;
    }

    /**
     * Get validation errors
     * 
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Validate email address
     * 
     * @param bool $checkDNS Check if domain has valid MX record
     * @return bool
     */
    public function isEmail(bool $checkDNS = false): bool
    {
        if (!filter_var($this->data, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        if ($checkDNS) {
            $domain = substr(strrchr($this->data, "@"), 1);
            return checkdnsrr($domain, "MX");
        }

        return true;
    }

    /**
     * Validate URL
     * 
     * @param bool $requireProtocol Require http/https protocol
     * @return bool
     */
    public function isUrl(bool $requireProtocol = true): bool
    {
        $flags = FILTER_FLAG_HOST_REQUIRED;
        if ($requireProtocol) {
            $flags |= FILTER_FLAG_SCHEME_REQUIRED;
        }

        return filter_var($this->data, FILTER_VALIDATE_URL, $flags) !== false;
    }

    /**
     * Validate IP address
     * 
     * @param string $version IP version (4, 6, all)
     * @return bool
     */
    public function isIp(string $version = 'all'): bool
    {
        $flags = 0;
        switch ($version) {
            case '4':
                $flags = FILTER_FLAG_IPV4;
                break;
            case '6':
                $flags = FILTER_FLAG_IPV6;
                break;
            case 'all':
                $flags = FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6;
                break;
        }

        return filter_var($this->data, FILTER_VALIDATE_IP, $flags) !== false;
    }

    /**
     * Validate date
     * 
     * @param string $format Date format
     * @return bool
     */
    public function isDate(string $format = 'Y-m-d'): bool
    {
        $date = \DateTime::createFromFormat($format, $this->data);
        return $date && $date->format($format) === $this->data;
    }

    /**
     * Validate numeric value
     * 
     * @param bool $allowNegative Allow negative numbers
     * @param bool $allowFloat Allow floating point numbers
     * @return bool
     */
    public function isNumeric(bool $allowNegative = true, bool $allowFloat = true): bool
    {
        if (!is_numeric($this->data)) {
            return false;
        }

        if (!$allowNegative && $this->data < 0) {
            return false;
        }

        if (!$allowFloat && strpos($this->data, '.') !== false) {
            return false;
        }

        return true;
    }

    /**
     * Validate string length
     * 
     * @param int $min Minimum length
     * @param int $max Maximum length
     * @return bool
     */
    public function length(int $min, int $max): bool
    {
        $length = mb_strlen($this->data);
        return $length >= $min && $length <= $max;
    }

    /**
     * Validate using regular expression
     * 
     * @param string $pattern Regular expression pattern
     * @return bool
     */
    public function matches(string $pattern): bool
    {
        return preg_match($pattern, $this->data) === 1;
    }

    /**
     * Validate if value is in array
     * 
     * @param array $values Allowed values
     * @param bool $strict Strict type checking
     * @return bool
     */
    public function inArray(array $values, bool $strict = false): bool
    {
        return in_array($this->data, $values, $strict);
    }

    /**
     * Validate credit card number
     * 
     * @return bool
     */
    public function isCreditCard(): bool
    {
        // Remove non-digits
        $number = preg_replace('/\D/', '', $this->data);
        
        // Check length
        if (strlen($number) < 13 || strlen($number) > 19) {
            return false;
        }
        
        // Luhn algorithm
        $sum = 0;
        $length = strlen($number);
        for ($i = 0; $i < $length; $i++) {
            $digit = (int)$number[$length - 1 - $i];
            if ($i % 2 === 1) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }
            $sum += $digit;
        }
        
        return $sum % 10 === 0;
    }

    /**
     * Validate phone number
     * 
     * @param string $pattern Regular expression pattern for validation
     * @return bool
     */
    public function isPhone(string $pattern = '/^[0-9\-\(\)\/\+\s]*$/'): bool
    {
        return $this->matches($pattern);
    }

    /**
     * Validate password strength
     * 
     * @param int $minLength Minimum length
     * @param bool $requireUppercase Require uppercase letter
     * @param bool $requireLowercase Require lowercase letter
     * @param bool $requireNumbers Require number
     * @param bool $requireSpecial Require special character
     * @return bool
     */
    public function isStrongPassword(
        int $minLength = 8,
        bool $requireUppercase = true,
        bool $requireLowercase = true,
        bool $requireNumbers = true,
        bool $requireSpecial = true
    ): bool {
        if (strlen($this->data) < $minLength) {
            return false;
        }

        if ($requireUppercase && !preg_match('/[A-Z]/', $this->data)) {
            return false;
        }

        if ($requireLowercase && !preg_match('/[a-z]/', $this->data)) {
            return false;
        }

        if ($requireNumbers && !preg_match('/[0-9]/', $this->data)) {
            return false;
        }

        if ($requireSpecial && !preg_match('/[^A-Za-z0-9]/', $this->data)) {
            return false;
        }

        return true;
    }

    /**
     * Validate file extension
     * 
     * @param array $allowedExtensions Allowed file extensions
     * @return bool
     */
    public function hasExtension(array $allowedExtensions): bool
    {
        $extension = strtolower(pathinfo($this->data, PATHINFO_EXTENSION));
        return in_array($extension, array_map('strtolower', $allowedExtensions));
    }

    /**
     * Validate file MIME type
     * 
     * @param array $allowedTypes Allowed MIME types
     * @return bool
     */
    public function hasMimeType(array $allowedTypes): bool
    {
        if (!file_exists($this->data)) {
            return false;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $this->data);
        finfo_close($finfo);

        return in_array($mimeType, $allowedTypes);
    }

    /**
     * Validate file size
     * 
     * @param int $maxSize Maximum file size in bytes
     * @return bool
     */
    public function hasMaxSize(int $maxSize): bool
    {
        if (!file_exists($this->data)) {
            return false;
        }

        return filesize($this->data) <= $maxSize;
    }

    /**
     * Validate JSON string
     * 
     * @return bool
     */
    public function isJson(): bool
    {
        if (!is_string($this->data)) {
            return false;
        }

        json_decode($this->data);
        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * Validate hex color code
     * 
     * @param bool $requireHash Require # prefix
     * @return bool
     */
    public function isHexColor(bool $requireHash = true): bool
    {
        $pattern = $requireHash ? '/^#[a-f0-9]{6}$/i' : '/^[a-f0-9]{6}$/i';
        return $this->matches($pattern);
    }

    /**
     * Validate against multiple rules
     * 
     * @param array $data Data to validate
     * @param array $rules Validation rules
     * @return bool
     */
    public function validate(array $data, array $rules): bool
    {
        $this->errors = [];
        
        foreach ($rules as $field => $fieldRules) {
            $value = $data[$field] ?? null;
            
            foreach ($fieldRules as $rule => $params) {
                if (is_numeric($rule)) {
                    $rule = $params;
                    $params = [];
                }
                
                if (!$this->validateRule($field, $value, $rule, $params)) {
                    if (!isset($this->errors[$field])) {
                        $this->errors[$field] = [];
                    }
                    $this->errors[$field][] = $this->getErrorMessage($field, $rule, $params);
                }
            }
        }
        
        return empty($this->errors);
    }

    /**
     * Validate a single rule
     * 
     * @param string $field Field name
     * @param mixed $value Field value
     * @param string $rule Rule name
     * @param mixed $params Rule parameters
     * @return bool
     */
    private function validateRule(string $field, $value, string $rule, $params): bool
    {
        $this->data = $value;
        
        switch ($rule) {
            case 'required':
                return !empty($value);
            
            case 'email':
                return $this->isEmail();
            
            case 'url':
                return $this->isUrl();
            
            case 'numeric':
                return $this->isNumeric();
            
            case 'min':
                return is_numeric($value) && $value >= $params;
            
            case 'max':
                return is_numeric($value) && $value <= $params;
            
            case 'length':
                return $this->length($params[0], $params[1]);
            
            case 'in':
                return $this->inArray($params);
            
            case 'regex':
                return $this->matches($params);
            
            default:
                return false;
        }
    }

    /**
     * Get error message for validation rule
     * 
     * @param string $field Field name
     * @param string $rule Rule name
     * @param mixed $params Rule parameters
     * @return string
     */
    private function getErrorMessage(string $field, string $rule, $params): string
    {
        $messages = [
            'required' => 'The %s field is required.',
            'email' => 'The %s must be a valid email address.',
            'url' => 'The %s must be a valid URL.',
            'numeric' => 'The %s must be a number.',
            'min' => 'The %s must be at least %s.',
            'max' => 'The %s must not be greater than %s.',
            'length' => 'The %s must be between %s and %s characters.',
            'in' => 'The selected %s is invalid.',
            'regex' => 'The %s format is invalid.'
        ];

        $message = $messages[$rule] ?? 'The %s field is invalid.';
        
        if (is_array($params)) {
            array_unshift($params, $field);
            return vsprintf($message, $params);
        }
        
        return sprintf($message, $field, $params);
    }
}
