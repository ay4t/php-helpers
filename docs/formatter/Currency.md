# 💰 Currency Formatter Documentation

Currency Formatter adalah helper untuk memformat nilai mata uang dengan berbagai opsi format yang umum digunakan dalam aplikasi.

## 📋 Penggunaan Dasar

```php
use Ay4t\Helper\HP;

$amount = HP::Currency(1000000);
```

## 🛠️ Method yang Tersedia

### 1. format(string $currency = 'IDR', int $decimal = 0)

Format nilai mata uang dengan simbol dan pemisah ribuan.

```php
// Format IDR default
$result = HP::Currency(1000000)->format();
// Result: Rp 1.000.000

// Format dengan currency custom
$result = HP::Currency(1000000)->format('USD');
// Result: $ 1,000,000

// Format dengan decimal
$result = HP::Currency(1000000.50)->format('IDR', 2);
// Result: Rp 1.000.000,50
```

### 2. counted()

Mengubah angka menjadi kata-kata dalam Bahasa Indonesia.

```php
$result = HP::Currency(1234567)->counted();
// Result: satu juta dua ratus tiga puluh empat ribu lima ratus enam puluh tujuh rupiah
```

### 3. clean()

Menghapus semua format dan mengembalikan nilai numerik murni.

```php
$result = HP::Currency("Rp 1.000.000,00")->clean();
// Result: 1000000
```

## 🌟 Contoh Penggunaan

### Format Mata Uang Indonesia (IDR)

```php
$amount = 1234567.89;

// Format standar
$result = HP::Currency($amount)->format();
// Result: Rp 1.234.568

// Format dengan 2 decimal
$result = HP::Currency($amount)->format('IDR', 2);
// Result: Rp 1.234.567,89

// Format terbilang
$result = HP::Currency($amount)->counted();
// Result: satu juta dua ratus tiga puluh empat ribu lima ratus enam puluh tujuh rupiah
```

### Format Mata Uang Lainnya

```php
$amount = 1234567.89;

// Format USD
$result = HP::Currency($amount)->format('USD', 2);
// Result: $ 1,234,567.89

// Format EUR
$result = HP::Currency($amount)->format('EUR', 2);
// Result: € 1.234.567,89
```

### Membersihkan Format

```php
// Membersihkan format dari string
$amount = "Rp 1.234.567,89";
$result = HP::Currency($amount)->clean();
// Result: 1234567.89
```

## 🔍 Tips Penggunaan

1. Gunakan `clean()` sebelum menyimpan ke database
2. Gunakan parameter decimal sesuai standar mata uang
3. Gunakan `counted()` untuk kebutuhan cetak dokumen formal
4. Perhatikan locale setting untuk format yang benar

## ⚠️ Catatan Penting

- Format default menggunakan IDR (Rupiah)
- Pemisah ribuan dan decimal menyesuaikan dengan standar mata uang
- Method `counted()` hanya tersedia untuk mata uang Rupiah
- Nilai negatif akan ditampilkan dengan tanda minus (-)
