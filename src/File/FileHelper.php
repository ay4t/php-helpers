<?php

namespace Ay4t\Helper\File;

/**
 * File Helper Class
 * Provides various file manipulation and information methods
 * 
 * @package Ay4t\Helper\File
 * @author Ayatulloh Ahad R
 */
class FileHelper implements \Ay4t\Helper\Interfaces\FormatterInterface
{
    /** @var string */
    private $filePath;

    /** @var array */
    private $allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    /**
     * Set the file path to be processed
     * 
     * @param string $filePath
     * @return self
     */
    public function set(string $filePath)
    {
        $this->filePath = $filePath;
        return $this;
    }

    /**
     * Get human-readable file size
     * 
     * @param int $precision Number of decimal places
     * @return string
     */
    public function getHumanSize(int $precision = 2): string
    {
        $bytes = filesize($this->filePath);
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Get MIME type of the file
     * 
     * @return string|false
     */
    public function getMimeType()
    {
        return mime_content_type($this->filePath);
    }

    /**
     * Get file extension
     * 
     * @param bool $lowercase Convert to lowercase
     * @return string
     */
    public function getExtension(bool $lowercase = true): string
    {
        $extension = pathinfo($this->filePath, PATHINFO_EXTENSION);
        return $lowercase ? strtolower($extension) : $extension;
    }

    /**
     * Get file name without extension
     * 
     * @return string
     */
    public function getBaseName(): string
    {
        return pathinfo($this->filePath, PATHINFO_FILENAME);
    }

    /**
     * Check if file is an image
     * 
     * @return bool
     */
    public function isImage(): bool
    {
        $mimeType = $this->getMimeType();
        return in_array($mimeType, $this->allowedImageTypes);
    }

    /**
     * Get image dimensions if file is an image
     * 
     * @return array|false Array with 'width' and 'height' keys or false if not an image
     */
    public function getImageDimensions()
    {
        if (!$this->isImage()) {
            return false;
        }

        $dimensions = getimagesize($this->filePath);
        if ($dimensions === false) {
            return false;
        }

        return [
            'width' => $dimensions[0],
            'height' => $dimensions[1]
        ];
    }

    /**
     * Copy file to a new location
     * 
     * @param string $destination Destination path
     * @param bool $overwrite Whether to overwrite existing file
     * @return bool
     */
    public function copy(string $destination, bool $overwrite = false): bool
    {
        if (!$overwrite && file_exists($destination)) {
            return false;
        }

        // Create destination directory if it doesn't exist
        $destDir = dirname($destination);
        if (!is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }

        return copy($this->filePath, $destination);
    }

    /**
     * Move file to a new location
     * 
     * @param string $destination Destination path
     * @param bool $overwrite Whether to overwrite existing file
     * @return bool
     */
    public function move(string $destination, bool $overwrite = false): bool
    {
        if ($this->copy($destination, $overwrite)) {
            return unlink($this->filePath);
        }
        return false;
    }

    /**
     * Get file modification time
     * 
     * @param string $format DateTime format
     * @return string
     */
    public function getModifiedTime(string $format = 'Y-m-d H:i:s'): string
    {
        return date($format, filemtime($this->filePath));
    }

    /**
     * Check if file is writable
     * 
     * @return bool
     */
    public function isWritable(): bool
    {
        return is_writable($this->filePath);
    }

    /**
     * Get file permissions as octal string
     * 
     * @return string
     */
    public function getPermissions(): string
    {
        return substr(sprintf('%o', fileperms($this->filePath)), -4);
    }

    /**
     * Calculate file hash
     * 
     * @param string $algorithm Hash algorithm (md5, sha1, etc.)
     * @return string
     */
    public function getHash(string $algorithm = 'md5'): string
    {
        return hash_file($algorithm, $this->filePath);
    }

    /**
     * Read file contents safely
     * 
     * @param int $maxLength Maximum length to read
     * @return string|false
     */
    public function readSafely(int $maxLength = 8388608) // 8MB default
    {
        $size = filesize($this->filePath);
        if ($size === false || $size > $maxLength) {
            return false;
        }

        return file_get_contents($this->filePath);
    }

    /**
     * Create a backup of the file
     * 
     * @param string $suffix Suffix to add to backup file name
     * @return bool
     */
    public function backup(string $suffix = '.bak'): bool
    {
        $backupPath = $this->filePath . $suffix;
        return $this->copy($backupPath, true);
    }

    /**
     * Get the result which is the file path.
     * Required by FormatterInterface.
     *
     * @return string
     */
    public function getResult(): string
    {
        return $this->filePath;
    }
}
