<?php

namespace Ay4t\Helper\Formatter;

/**
 * Math Helper Class
 * Contoh Penggunaan:
 * - HP::Math()->isChance(10.5) // Peluang 10.5%
 * - HP::Math()->isChance(0.0001) // Peluang 0.0001%
 */
class MathHelper implements \Ay4t\Helper\Interfaces\FormatterInterface
{
    private $value;

    /**
     * Set nilai awal (opsional untuk MathHelper)
     *
     * @param mixed $value
     * @return self
     */
    public function set($value = null)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Fungsi untuk menentukan kejadian berdasarkan probabilitas/persentase.
     *
     * @param float $percentage Peluang dalam persen (Contoh: 100 = 100%, 0.1 = 0.1%)
     * @return bool True jika kejadian terjadi, False jika tidak.
     */
    public function isChance(float $percentage): bool
    {
        // 1. Tangani nilai absolut untuk efisiensi
        if ($percentage <= 0.0) {
            return false;
        }
        if ($percentage >= 100.0) {
            return true;
        }

        // 2. Tentukan tingkat presisi desimal.
        // Angka 10000 berarti kita mendukung hingga 4 angka di belakang koma (misal 0.0001%).
        $precision = 10000;

        // 3. Hitung batas maksimal pool angka acak (100% * presisi)
        $maxPool = 100 * $precision;

        // 4. Ubah persentase target menjadi angka bulat (threshold)
        $threshold = (int) round($percentage * $precision);

        // 5. Hasilkan angka acak dari 1 hingga max pool menggunakan algoritma CSPRNG
        $randomNumber = random_int(1, $maxPool);

        // 6. Jika angka acak berada di bawah atau sama dengan threshold, berarti "Kena" (True)
        return $randomNumber <= $threshold;
    }

    /**
     * Get the result of the formatting.
     *
     * @return mixed
     */
    public function getResult()
    {
        return $this->value;
    }
}
