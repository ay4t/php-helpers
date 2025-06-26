<?php

namespace Ay4t\Helper\String;

/**
 * String Helper Class
 * Provides various string manipulation methods
 * 
 * @package Ay4t\Helper\String
 * @author Ayatulloh Ahad R
 */
class StringHelper implements \Ay4t\Helper\Interfaces\FormatterInterface
{
    /** @var string */
    private $string;

    /**
     * Set the string to be processed
     * 
     * @param string $string
     * @return self
     */
    public function set(string $string)
    {
        $this->string = $string;
        return $this;
    }

    /**
     * Create a URL-friendly slug from a string
     * 
     * @param string $separator Separator between words
     * @return string
     */
    public function slugify(string $separator = '-'): string
    {
        // Convert to lowercase and remove accents
        $slug = mb_strtolower($this->string, 'UTF-8');
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $slug);

        // Replace non-alphanumeric characters with separator
        $slug = preg_replace('/[^a-z0-9-]/', $separator, $slug);
        
        // Remove duplicate separators
        $slug = preg_replace('/-+/', $separator, $slug);
        
        // Remove leading/trailing separator
        return trim($slug, $separator);
    }

    /**
     * Truncate a string to a specified length
     * 
     * @param int $length Maximum length
     * @param string $append String to append if truncated
     * @param bool $wordSafe Whether to preserve whole words
     * @return string
     */
    public function truncate(int $length = 100, string $append = '...', bool $wordSafe = true): string
    {
        if (mb_strlen($this->string) <= $length) {
            return $this->string;
        }

        $truncated = mb_substr($this->string, 0, $length);

        if ($wordSafe) {
            // Find last space within length
            $lastSpace = mb_strrpos($truncated, ' ');
            if ($lastSpace !== false) {
                $truncated = mb_substr($truncated, 0, $lastSpace);
            }
        }

        return $truncated . $append;
    }

    /**
     * Create an excerpt from a longer text
     * 
     * @param int $length Maximum length of the excerpt
     * @param string $append String to append if truncated
     * @return string
     */
    public function excerpt(int $length = 150, string $append = '...'): string
    {
        // Strip HTML tags and convert entities
        $text = strip_tags($this->string);
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');

        return $this->set($text)->truncate($length, $append, true);
    }

    /**
     * Convert a string to a more human-readable format
     * 
     * @return string
     */
    public function humanize(): string
    {
        // Replace underscores and hyphens with spaces
        $string = preg_replace('/[_-]+/', ' ', $this->string);
        
        // Capitalize first letter of each word
        $string = ucwords($string);
        
        return trim($string);
    }

    /**
     * Mask a portion of the string
     * 
     * @param int $start Position to start masking
     * @param int $length Length of the mask
     * @param string $mask Character to use for masking
     * @return string
     */
    public function mask(int $start = 0, int $length = null, string $mask = '*'): string
    {
        $strLen = mb_strlen($this->string);
        
        // If no length specified, mask until end
        if ($length === null) {
            $length = $strLen - $start;
        }

        // Validate positions
        if ($start < 0 || $start >= $strLen) {
            return $this->string;
        }

        // Create mask string
        $maskedPart = str_repeat($mask, $length);
        
        // Replace portion with mask
        return mb_substr($this->string, 0, $start) . 
               $maskedPart . 
               mb_substr($this->string, $start + $length);
    }

    /**
     * Convert camelCase to snake_case
     * 
     * @return string
     */
    public function toSnakeCase(): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $this->string));
    }

    /**
     * Convert snake_case to camelCase
     * 
     * @param bool $firstUpper Whether to capitalize first character
     * @return string
     */
    public function toCamelCase(bool $firstUpper = false): string
    {
        $string = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->string)));
        
        if (!$firstUpper) {
            $string = lcfirst($string);
        }
        
        return $string;
    }

    /**
     * Remove all whitespace from the string
     * 
     * @return string
     */
    public function removeWhitespace(): string
    {
        return preg_replace('/\s+/', '', $this->string);
    }

    /**
     * Extract all email addresses from the string
     * 
     * @return array
     */
    public function extractEmails(): array
    {
        preg_match_all('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $this->string, $matches);
        return $matches[0] ?? [];
    }

    /**
     * Convert the string to title case with proper capitalization rules
     * 
     * @return string
     */
    public function toTitleCase(): string
    {
        // Words that shouldn't be capitalized (unless first/last)
        $smallWords = ['a', 'an', 'and', 'as', 'at', 'but', 'by', 'for', 'in', 
                      'of', 'on', 'or', 'the', 'to', 'via', 'with'];

        $words = explode(' ', mb_strtolower($this->string));
        $count = count($words);

        foreach ($words as $i => &$word) {
            // Always capitalize first and last word
            if ($i === 0 || $i === ($count - 1) || !in_array($word, $smallWords)) {
                $word = ucfirst($word);
            }
        }

        return implode(' ', $words);
    }

    /**
     * Generate initials from a string (e.g., "John Doe" -> "JD")
     * 
     * @param int $length Maximum number of initials
     * @return string
     */
    public function initials(int $length = 2): string
    {
        $words = preg_split('/\s+/', $this->string);
        $initials = array_map(function($word) {
            return mb_substr($word, 0, 1);
        }, $words);

        return mb_strtoupper(implode('', array_slice($initials, 0, $length)));
    }

    /**
     * Get the result of the formatting.
     *
     * @return string
     */
    public function getResult()
    {
        return $this->string;
    }
}
