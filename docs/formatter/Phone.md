# 📱 Phone Formatter Documentation

Phone Formatter adalah helper untuk memformat nomor telepon dengan berbagai standar dan format yang umum digunakan.

## 📋 Penggunaan Dasar

```php
use Ay4t\Helper\HP;

$phone = HP::Phone("081234567890");
```

## 🛠️ Method yang Tersedia

### 1. format(string $format = null)

Format nomor telepon sesuai dengan format yang ditentukan.

```php
// Format default (0812-3456-7890)
$result = HP::Phone("081234567890")->format();

// Format custom
$result = HP::Phone("081234567890")->format("+62 %d%d%d-%d%d%d%d");
```

### 2. setCountryCode(string $code)

Mengatur kode negara untuk nomor telepon.

```php
$result = HP::Phone("081234567890")
    ->setCountryCode("ID")
    ->format();

// Result: +62812-3456-7890
```

### 3. onlyNumber()

Mengembalikan nomor telepon dalam format angka saja.

```php
$result = HP::Phone("0812-3456-7890")->onlyNumber();

// Result: 081234567890
```

### 4. withCountryCode()

Mengembalikan nomor telepon dengan kode negara.

```php
$result = HP::Phone("081234567890")->withCountryCode();

// Result: +62812-3456-7890
```

## 🌟 Contoh Penggunaan

### Format Standar Indonesia

```php
$phone = "081234567890";

// Format standar
$result = HP::Phone($phone)->format();
// Result: 0812-3456-7890

// Dengan kode negara
$result = HP::Phone($phone)->withCountryCode();
// Result: +62812-3456-7890

// Hanya angka
$result = HP::Phone($phone)->onlyNumber();
// Result: 081234567890
```

### Format Custom

```php
$phone = "081234567890";

// Format custom dengan separator berbeda
$result = HP::Phone($phone)->format("0%d%d%d.%d%d%d%d.%d%d%d%d");
// Result: 0812.3456.7890

// Format dengan kode negara custom
$result = HP::Phone($phone)
    ->setCountryCode("US")
    ->format("+1 (%d%d%d) %d%d%d-%d%d%d%d");
// Result: +1 (812) 345-6789
```

## 🔍 Tips Penggunaan

1. Gunakan `onlyNumber()` ketika menyimpan ke database
2. Gunakan `withCountryCode()` untuk format internasional
3. Gunakan `format()` dengan parameter custom untuk kebutuhan format khusus
4. Selalu validasi nomor telepon sebelum memformat

## ⚠️ Catatan Penting

- Format default menggunakan standar Indonesia
- Kode negara default adalah "ID" (Indonesia)
- Nomor telepon yang tidak valid akan mengembalikan string kosong
- Karakter selain angka akan dihapus secara otomatis
