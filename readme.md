# 🚀 PHP Helpers

Kumpulan helper PHP untuk mempermudah development aplikasi Anda.

## 📦 Instalasi

```bash
composer require ay4t/php-helpers
```

## 🎯 Fitur Utama

- 📱 **Phone Formatter**: Format nomor telepon dengan berbagai standar
- 💰 **Currency Formatter**: Format mata uang dengan berbagai opsi
- 📅 **DateTime Formatter**: Format tanggal dan waktu
- 🔄 **Array Helper**: Manipulasi array dengan mudah dan ekspresif

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

- [📱 Phone Formatter](docs/formatter/Phone.md)
- [💰 Currency Formatter](docs/formatter/Currency.md)
- [📅 DateTime Formatter](docs/formatter/Datetime.md)
- [🔄 Array Helper](docs/formatter/ArrayHelper.md)

## 🤝 Kontribusi

Kami sangat menghargai kontribusi Anda! Silakan buat pull request atau laporkan issue jika Anda menemukan bug atau memiliki saran perbaikan.

## 📝 Lisensi

MIT License - lihat file [LICENSE](LICENSE) untuk detail lebih lanjut.

## ✨ Kredit

Dibuat dengan ❤️ oleh [Ayatulloh Ahad R](https://github.com/ay4t)