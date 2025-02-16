# 📝 String Helper Documentation

String Helper menyediakan berbagai method untuk memanipulasi dan memformat string dengan mudah dan efisien.

## 📋 Penggunaan Dasar

```php
use Ay4t\Helper\HP;

$string = HP::String("Your string here");
```

## 🛠️ Method yang Tersedia

### 1. slugify(string $separator = '-')
Membuat slug URL-friendly dari string.

```php
$result = HP::String("Hello World!")->slugify();
// Result: "hello-world"

$result = HP::String("Hello World!")->slugify('_');
// Result: "hello_world"
```

### 2. truncate(int $length = 100, string $append = '...', bool $wordSafe = true)
Memotong string dengan panjang tertentu.

```php
$text = "This is a very long text that needs to be truncated";
$result = HP::String($text)->truncate(20);
// Result: "This is a very..."

// Dengan word safe = false
$result = HP::String($text)->truncate(20, '...', false);
// Result: "This is a very lon..."
```

### 3. excerpt(int $length = 150, string $append = '...')
Membuat kutipan dari text panjang.

```php
$html = "<p>This is a long HTML text with <b>formatting</b> that needs to be excerpted.</p>";
$result = HP::String($html)->excerpt(20);
// Result: "This is a long..."
```

### 4. humanize()
Mengubah string menjadi format yang mudah dibaca.

```php
$result = HP::String("user_first_name")->humanize();
// Result: "User First Name"
```

### 5. mask(int $start = 0, int $length = null, string $mask = '*')
Menyembunyikan sebagian string.

```php
// Mask credit card
$result = HP::String("4111111111111111")->mask(6, 8);
// Result: "411111********11"

// Mask email
$result = HP::String("user@example.com")->mask(2, 5);
// Result: "us*****@example.com"
```

### 6. toSnakeCase() & toCamelCase()
Mengubah format string.

```php
// To snake case
$result = HP::String("getUserName")->toSnakeCase();
// Result: "get_user_name"

// To camel case
$result = HP::String("user_first_name")->toCamelCase();
// Result: "userFirstName"

// To pascal case
$result = HP::String("user_first_name")->toCamelCase(true);
// Result: "UserFirstName"
```

### 7. initials(int $length = 2)
Mengambil inisial dari string.

```php
$result = HP::String("John Doe")->initials();
// Result: "JD"

$result = HP::String("John Michael Doe")->initials(3);
// Result: "JMD"
```

### 8. toTitleCase()
Mengubah string menjadi format judul.

```php
$result = HP::String("the quick brown fox")->toTitleCase();
// Result: "The Quick Brown Fox"
```

## 🌟 Contoh Penggunaan Kompleks

### Format Nama File
```php
$filename = "my-document-name.pdf";
$result = HP::String($filename)
    ->getBaseName() // Hapus ekstensi
    ->humanize()    // Format readable
    ->toTitleCase();// Format judul
// Result: "My Document Name"
```

### Format URL
```php
$title = "This is a Blog Post Title! (2023)";
$result = HP::String($title)
    ->slugify()     // URL friendly
    ->truncate(30); // Batasi panjang
// Result: "this-is-a-blog-post-title-2023"
```

## 🔍 Tips Penggunaan

1. Gunakan `slugify()` untuk membuat URL yang SEO-friendly
2. Gunakan `excerpt()` untuk membuat preview content
3. Gunakan `mask()` untuk data sensitif seperti password atau nomor kartu kredit
4. Gunakan `humanize()` untuk menampilkan nama variable atau kolom database
5. Gunakan `initials()` untuk avatar atau icon dengan inisial nama

## ⚠️ Catatan Penting

- Semua method mendukung UTF-8
- Method `truncate()` dan `excerpt()` menjaga integritas kata secara default
- Method `mask()` berguna untuk keamanan data sensitif
- Gunakan method chaining untuk operasi yang lebih kompleks
