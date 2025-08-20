# 📦 Shipping Container Checker (ISO 6346)

Helper ini memvalidasi dan menghitung check digit untuk nomor kontainer standar ISO 6346.

Contoh nomor: `CSQU3054383` (diambil dari Wikipedia/ISO 6346), di mana:
- `CSQ` = Owner code (3 huruf)
- `U` = Category identifier (1 huruf)
- `305438` = Serial number (6 digit)
- `3` = Check digit (1 digit)

## ✨ Fitur
- Terima input fleksibel: `CSQU3054383`, `CSQU305438`, `CSQU 305438 3`.
- Hitung check digit dari 10 karakter pertama (owner+category+serial).
- Validasi nomor lengkap yang menyertakan check digit.
- Normalisasi output ke format standar tanpa spasi.

## 📦 Namespace & Kelas
- Kelas: `Ay4t\Helper\Validation\ShippingContainerChecker`
- Akses via facade: `Ay4t\Helper\HP::ShippingContainerChecker(...)`

## 🔧 Instalasi & Import
Pastikan autoload Composer aktif. Di project ini sudah tersedia melalui `vendor/autoload.php`.

```php
require_once __DIR__ . '/vendor/autoload.php';
use Ay4t\Helper\HP;
```

## 🚀 Penggunaan Dasar

### 1) Validasi nomor lengkap
```php
use Ay4t\Helper\HP;

$checker = HP::ShippingContainerChecker('CSQU3054383');
$checker->isValid();      // true
$checker->getResult();    // "CSQU3054383"
```

### 2) Hitung check digit dari 10 karakter pertama
```php
$checker = HP::ShippingContainerChecker('CSQU305438');
$checker->expectedCheckDigit();  // 3
$checker->getResult();           // "CSQU3054383"
```

### 3) Input dengan spasi atau pemisah lainnya
```php
$checker = HP::ShippingContainerChecker('CSQU 305438 3');
$checker->isValid();      // true
$checker->getResult();    // "CSQU3054383"
```

### 4) Check digit salah
```php
$checker = HP::ShippingContainerChecker('CSQU3054384');
$checker->isValid();      // false
$checker->expectedCheckDigit();  // 3
$checker->getResult();           // "CSQU3054383"
```

## 🧠 API Reference

### set(string $container, ?string $category = null): self
- Mengatur data kontainer dari satu string fleksibel.
- Secara otomatis mengenali owner code (3 huruf), category (1 huruf), serial (6 digit), dan check digit (opsional).
- Jika `$category` diberikan, akan override category hasil parsing.
- Melempar `InvalidArgumentException` jika format tidak valid.

### calculateCheckDigit(?string $owner = null, ?string $category = null, ?string $serial = null): int
- Hitung check digit dari gabungan 10 karakter pertama.
- Bisa diberikan parameter komponen secara eksplisit; default gunakan nilai dari `set()`.

### isValid(): bool
- Mengembalikan `true` jika input menyertakan check digit dan nilainya sesuai hasil perhitungan.
- Jika check digit tidak diberikan di input, mengembalikan `false`.

### expectedCheckDigit(): int
- Mengembalikan check digit yang benar berdasarkan komponen saat ini.

### getResult(): string
- Mengembalikan nomor dalam format standar lengkap (owner+category+serial+check_digit).

## 🧮 Catatan Algoritma (ISO 6346)
- Huruf dipetakan ke nilai numerik khusus ISO 6346:
  - A=10, B=12, C=13, D=14, E=15, F=16, G=17, H=18, I=19,
  - J=20, K=21, L=23, M=24, N=25, O=26, P=27, Q=28, R=29,
  - S=30, T=31, U=32, V=34, W=35, X=36, Y=37, Z=38
- Bobot posisi untuk 10 karakter pertama adalah 2^pos (posisi mulai 0).
- Jumlahkan (nilai_karakter * bobot).
- Sisa bagi 11 => jika 10 maka check digit = 0, selain itu = sisa.

## 🧪 Contoh Lengkap (CLI)
Lihat file contoh: `examples/shipping_container_example.php`

Jalankan:
```bash
php examples/shipping_container_example.php
# atau
php examples/shipping_container_example.php MSKU123456 CSQU3054383 "CSQU 305438 3"
```

## ⚠️ Error & Validasi
- `Invalid owner/category code` untuk prefix yang tidak memenuhi pola 4 huruf (3 owner + 1 kategori).
- `Invalid serial` untuk serial yang tidak 6 digit angka.
- `Invalid check digit` jika check digit bukan satu digit 0-9.

## 📚 Referensi
- ISO 6346 — Shipping container coding, identification, and marking.
- Contoh publik: `CSQU3054383` (Wikipedia / bahan referensi umum).
