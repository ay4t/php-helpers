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

// Format nomor telepon
$phone = HP::Phone("081234567890")->format();

// Format mata uang
$amount = HP::Currency(1000000)->format();

// Format tanggal
$date = HP::Datetime("2023-01-01")->format("d F Y");

// Manipulasi array
$result = HP::Array($data)->where('status', 'active')->pluck('name');
```

## 📚 Dokumentasi

Dokumentasi lengkap tersedia untuk setiap helper:

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