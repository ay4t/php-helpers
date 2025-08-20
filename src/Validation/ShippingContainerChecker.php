<?php

namespace Ay4t\Helper\Validation;

/**
 * Shipping Container Check Digit (ISO 6346) helper
 *
 * - Mendukung input: "CSQU3054383", "CSQU 305438 3", atau prefix+serial terpisah.
 * - Algoritma: map huruf ke nilai ISO, bobot 2^pos untuk 10 karakter pertama,
 *   jumlah % 11; jika hasil 10 maka check digit = 0; selain itu = hasil.
 */
class ShippingContainerChecker
{
    /** @var string */
    protected string $ownerCode = '';
    /** @var string */
    protected string $category = 'U';
    /** @var string */
    protected string $serial = '';
    /** @var int|null */
    protected ?int $providedCheck = null;

    /**
     * Set container number in a flexible format.
     * Accepts: "CSQU3054383", "CSQU 305438 3", or parts
     */
    public function set(string $container, ?string $category = null): self
    {
        // Normalize: remove spaces and non-alphanumeric
        $norm = strtoupper(preg_replace('/[^A-Z0-9]/i', '', $container));

        // Expect at least 10 chars (4 letters + 6 digits)
        if (strlen($norm) < 10) {
            throw new \InvalidArgumentException('Container number too short');
        }

        $prefix = substr($norm, 0, 4);
        $serial = substr($norm, 4, 6);
        $check  = strlen($norm) >= 11 ? substr($norm, 10, 1) : null;

        if (!preg_match('/^[A-Z]{4}$/', $prefix)) {
            throw new \InvalidArgumentException('Invalid owner/category code');
        }
        if (!preg_match('/^[0-9]{6}$/', $serial)) {
            throw new \InvalidArgumentException('Invalid serial');
        }
        if ($check !== null && !preg_match('/^[0-9]$/', $check)) {
            throw new \InvalidArgumentException('Invalid check digit');
        }

        $this->ownerCode = substr($prefix, 0, 3);
        $this->category  = $category ? strtoupper($category) : substr($prefix, 3, 1);
        $this->serial    = $serial;
        $this->providedCheck = $check !== null ? (int)$check : null;

        return $this;
    }

    /**
     * Hitung check digit dari owner+category+serial (10 karakter pertama)
     */
    public function calculateCheckDigit(?string $owner = null, ?string $category = null, ?string $serial = null): int
    {
        $owner = $owner ?? $this->ownerCode;
        $category = $category ?? $this->category;
        $serial = $serial ?? $this->serial;

        if (!preg_match('/^[A-Z]{3}$/', $owner) || !preg_match('/^[A-Z]{1}$/', $category) || !preg_match('/^[0-9]{6}$/', $serial)) {
            throw new \InvalidArgumentException('Invalid components for calculation');
        }

        $first10 = $owner . $category . $serial; // 10 chars
        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $char = $first10[$i];
            $value = ctype_alpha($char) ? self::letterValue($char) : (int)$char;
            $weight = 1 << $i; // 2^i
            $sum += $value * $weight;
        }
        $remainder = $sum % 11;
        $check = $remainder % 10; // if 10 => 0
        return $check;
    }

    /**
     * Validasi nomor container (jika disediakan check digit)
     */
    public function isValid(): bool
    {
        if ($this->providedCheck === null) {
            return false;
        }
        return $this->providedCheck === $this->calculateCheckDigit();
    }

    /**
     * Dapatkan check digit yang diharapkan dari data saat ini
     */
    public function expectedCheckDigit(): int
    {
        return $this->calculateCheckDigit();
    }

    /**
     * Kembalikan format terstandardisasi: OWNER CATEGORY SERIAL CHECK
     * contoh: CSQU3054383
     */
    public function getResult(): string
    {
        $check = $this->calculateCheckDigit();
        return sprintf('%s%s%s%d', $this->ownerCode, $this->category, $this->serial, $check);
    }

    /**
     * Nilai huruf sesuai ISO 6346
     * A=10, B=12, C=13, D=14, E=15, F=16, G=17, H=18, I=19, J=20,
     * K=21, L=23, M=24, N=25, O=26, P=27, Q=28, R=29, S=30, T=31,
     * U=32, V=34, W=35, X=36, Y=37, Z=38
     */
    public static function letterValue(string $letter): int
    {
        static $map = [
            'A' => 10, 'B' => 12, 'C' => 13, 'D' => 14, 'E' => 15, 'F' => 16, 'G' => 17, 'H' => 18, 'I' => 19,
            'J' => 20, 'K' => 21, 'L' => 23, 'M' => 24, 'N' => 25, 'O' => 26, 'P' => 27, 'Q' => 28, 'R' => 29,
            'S' => 30, 'T' => 31, 'U' => 32, 'V' => 34, 'W' => 35, 'X' => 36, 'Y' => 37, 'Z' => 38,
        ];
        $letter = strtoupper($letter);
        if (!isset($map[$letter])) {
            throw new \InvalidArgumentException('Invalid letter: ' . $letter);
        }
        return $map[$letter];
    }
}
