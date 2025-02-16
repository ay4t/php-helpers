# 📅 DateTime Formatter Documentation

DateTime Formatter adalah helper untuk memformat tanggal dan waktu dengan berbagai format yang umum digunakan dalam aplikasi.

## 📋 Penggunaan Dasar

```php
use Ay4t\Helper\HP;

$date = HP::Datetime("2023-01-01");
```

## 🛠️ Method yang Tersedia

### 1. format(string $format = 'd F Y')

Format tanggal dan waktu sesuai dengan format yang ditentukan.

```php
// Format default
$result = HP::Datetime("2023-01-01")->format();
// Result: 01 Januari 2023

// Format custom
$result = HP::Datetime("2023-01-01 14:30:00")->format("d/m/Y H:i");
// Result: 01/01/2023 14:30
```

### 2. toIndonesian()

Mengubah tanggal ke format Indonesia.

```php
$result = HP::Datetime("2023-01-01")->toIndonesian();
// Result: 01 Januari 2023
```

### 3. diffForHumans()

Menampilkan perbedaan waktu dalam format yang mudah dibaca.

```php
$result = HP::Datetime("2023-01-01")->diffForHumans();
// Result: 2 tahun yang lalu
```

## 🌟 Contoh Penggunaan

### Format Tanggal Indonesia

```php
$date = "2023-01-01";

// Format lengkap
$result = HP::Datetime($date)->toIndonesian();
// Result: 01 Januari 2023

// Format dengan hari
$result = HP::Datetime($date)->format("l, d F Y");
// Result: Minggu, 01 Januari 2023

// Format singkat
$result = HP::Datetime($date)->format("d/m/Y");
// Result: 01/01/2023
```

### Format Waktu

```php
$datetime = "2023-01-01 14:30:45";

// Format waktu 24 jam
$result = HP::Datetime($datetime)->format("H:i:s");
// Result: 14:30:45

// Format waktu 12 jam
$result = HP::Datetime($datetime)->format("h:i A");
// Result: 02:30 PM

// Format lengkap dengan waktu
$result = HP::Datetime($datetime)->format("d F Y H:i");
// Result: 01 Januari 2023 14:30
```

### Perbedaan Waktu

```php
// Waktu yang lalu
$result = HP::Datetime("2023-01-01")->diffForHumans();
// Result: 2 tahun yang lalu

// Waktu yang akan datang
$result = HP::Datetime("2025-01-01")->diffForHumans();
// Result: 2 tahun dari sekarang
```

## 🔍 Tips Penggunaan

1. Gunakan format ISO untuk input tanggal (YYYY-MM-DD)
2. Manfaatkan `toIndonesian()` untuk tampilan yang lebih familiar
3. Gunakan `diffForHumans()` untuk tampilan yang lebih user-friendly
4. Perhatikan timezone setting untuk hasil yang akurat

## ⚠️ Catatan Penting

- Format default menggunakan Bahasa Indonesia
- Timezone default menggunakan Asia/Jakarta
- Method `toIndonesian()` menggunakan format "d F Y"
- Input tanggal harus dalam format yang valid
