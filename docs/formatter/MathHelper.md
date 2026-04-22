# Math Helper

Kelas pembantu untuk operasi matematika dan probabilitas.

## Penggunaan

### `isChance(float $percentage)`
Menentukan apakah suatu kejadian terjadi berdasarkan probabilitas/persentase yang diberikan.

**Parameter:**
- `float $percentage`: Peluang dalam persen (Contoh: `100` = 100%, `0.1` = 0.1%)

**Return:**
- `bool`: `true` jika kejadian terjadi, `false` jika tidak.

**Contoh:**
```php
// Peluang 10%
if (HP::Math()->isChance(10)) {
    echo "Kena!";
}

// Peluang sangat kecil 0.0001%
if (HP::Math()->isChance(0.0001)) {
    echo "Sangat Langka!";
}
```
