# 🚀 PHP Helpers

Kumpulan helper PHP untuk mempermudah development aplikasi Anda.

## 📦 Instalasi

```bash
composer require ay4t/php-helpers
```

## 🎯 Fitur Utama

### 📊 Formatters
- 📱 **Phone Formatter**: Format nomor telepon dengan berbagai standar
- 💰 **Currency Formatter**: Format mata uang dengan berbagai opsi
- 📅 **DateTime Formatter**: Format tanggal dan waktu
- 🔄 **Array Helper**: Manipulasi array dengan mudah dan ekspresif

### 🛠️ String & File
- 📝 **String Helper**: Manipulasi string dengan berbagai method
- 📂 **File Helper**: Operasi file dan direktori yang aman

### 🔒 Security & Validation
- 🔐 **Security Helper**: Hashing password, enkripsi data, dan pembuatan token
- ✅ **Validation Helper**: Validasi data dengan berbagai aturan

### 🌐 Web
- 🔗 **URL Helper**: Parsing dan manipulasi URL
- 📄 **HTML Helper**: Pembuatan elemen HTML dan form builder yang aman

## 🛠️ Penggunaan Dasar

```php
use Ay4t\Helper\HP;

// Phone: format internasional
$phone = HP::Phone('081234567890', 'ID')->getResult();            // "+62 812-3456-7890"

// Phone: hanya integer (MSISDN)
$msisdn = HP::Phone('081234567890', 'ID')->onlyInteger(true)->getResult(); // "6281234567890"

// Currency: format mata uang
$amount = HP::Currency(1000000, 'IDR', 2)->getResult();

// Currency: terbilang (spell-out)
$terbilang = HP::Currency(1000000, 'IDR', 2)->counted()->getResult();

// Datetime (Carbon wrapper)
$now = HP::Datetime()::now()->toDateTimeString();

// Array helper
$names = HP::Array($data)->where('status', 'active')->pluck('name');

// String helper
$slug = HP::String('Hello World!')->slugify();                      // "hello-world"

// URL helper
$url  = HP::URL('https://example.com?a=1')->addQueryParam('b', 2)->getResult();

// HTML helper
$aTag = HP::HTML()->link('https://example.com', 'Visit');

// Security helper
$hashed = HP::Security()->hashPassword('secret');

// Validation helper
$isEmail = HP::Validation('test@example.com')->isEmail();
```

## 📚 Dokumentasi

Beberapa dokumentasi tersedia:

### 📊 Formatters
- [📱 Phone Formatter](docs/formatter/Phone.md)
- [💰 Currency Formatter](docs/formatter/Currency.md)
- [📅 DateTime Formatter](docs/formatter/Datetime.md)
- [🔄 Array Helper](docs/formatter/ArrayHelper.md)

### 🛠️ String & File
- [📝 String Helper](docs/String/StringHelper.md)
- [📂 File Helper](docs/File/FileHelper.md)

### 🔒 Security & Validation
- [🔐 Security Helper](docs/Security/SecurityHelper.md)
- [✅ Validation Helper](docs/Validation/ValidationHelper.md)

### 🌐 Web
- [🔗 URL Helper](docs/URL/URLHelper.md)
- [📄 HTML Helper](docs/HTML/HTMLHelper.md)

## 🤝 Kontribusi

Kami sangat menghargai kontribusi Anda! Silakan buat pull request atau laporkan issue jika Anda menemukan bug atau memiliki saran perbaikan.

## 📝 Lisensi

MIT License - lihat file [LICENSE](LICENSE) untuk detail lebih lanjut.

## ✨ Kredit

Dibuat dengan ❤️ oleh [Ayatulloh Ahad R](https://github.com/ay4t)