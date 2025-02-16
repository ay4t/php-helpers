# 📂 File Helper Documentation

File Helper menyediakan berbagai method untuk memanipulasi dan mendapatkan informasi file dengan mudah dan aman.

## 📋 Penggunaan Dasar

```php
use Ay4t\Helper\HP;

$file = HP::File("/path/to/file.txt");
```

## 🛠️ Method yang Tersedia

### 1. getHumanSize(int $precision = 2)
Mendapatkan ukuran file dalam format yang mudah dibaca.

```php
$result = HP::File("large-file.zip")->getHumanSize();
// Result: "1.5 MB"

$result = HP::File("image.jpg")->getHumanSize(0);
// Result: "2 MB"
```

### 2. getMimeType()
Mendapatkan MIME type file.

```php
$result = HP::File("document.pdf")->getMimeType();
// Result: "application/pdf"

$result = HP::File("image.jpg")->getMimeType();
// Result: "image/jpeg"
```

### 3. getExtension(bool $lowercase = true)
Mendapatkan ekstensi file.

```php
$result = HP::File("Document.PDF")->getExtension();
// Result: "pdf"

$result = HP::File("Image.JPG")->getExtension(false);
// Result: "JPG"
```

### 4. isImage()
Memeriksa apakah file adalah gambar.

```php
$result = HP::File("photo.jpg")->isImage();
// Result: true

$result = HP::File("document.pdf")->isImage();
// Result: false
```

### 5. getImageDimensions()
Mendapatkan dimensi gambar.

```php
$result = HP::File("photo.jpg")->getImageDimensions();
// Result: ['width' => 1920, 'height' => 1080]
```

### 6. copy(string $destination, bool $overwrite = false)
Menyalin file ke lokasi baru.

```php
$result = HP::File("original.txt")->copy("/backup/original.txt");
// Result: true/false

// Dengan overwrite
$result = HP::File("original.txt")->copy("/backup/original.txt", true);
```

### 7. move(string $destination, bool $overwrite = false)
Memindahkan file ke lokasi baru.

```php
$result = HP::File("old/file.txt")->move("new/file.txt");
// Result: true/false
```

### 8. getModifiedTime(string $format = 'Y-m-d H:i:s')
Mendapatkan waktu modifikasi file.

```php
$result = HP::File("document.pdf")->getModifiedTime();
// Result: "2023-01-01 12:00:00"

$result = HP::File("document.pdf")->getModifiedTime("d F Y");
// Result: "01 January 2023"
```

### 9. getHash(string $algorithm = 'md5')
Menghitung hash file.

```php
$result = HP::File("document.pdf")->getHash();
// Result: "d41d8cd98f00b204e9800998ecf8427e"

$result = HP::File("document.pdf")->getHash('sha1');
// Result: "da39a3ee5e6b4b0d3255bfef95601890afd80709"
```

## 🌟 Contoh Penggunaan Kompleks

### Backup File dengan Informasi
```php
$file = HP::File("important.doc");

if ($file->isWritable()) {
    // Buat backup dengan timestamp
    $timestamp = date('Y-m-d-His');
    $backupName = "backup-{$timestamp}.doc";
    
    if ($file->copy("/backup/{$backupName}")) {
        $info = [
            'size' => $file->getHumanSize(),
            'modified' => $file->getModifiedTime(),
            'hash' => $file->getHash()
        ];
        // Simpan info backup
    }
}
```

### Proses Upload Gambar
```php
$upload = HP::File($_FILES['image']['tmp_name']);

if ($upload->isImage()) {
    $dimensions = $upload->getImageDimensions();
    
    if ($dimensions['width'] <= 2000 && $upload->getHumanSize(0) <= "5 MB") {
        $upload->move("/uploads/images/new-image.jpg", true);
    }
}
```

## 🔍 Tips Penggunaan

1. Selalu gunakan `isWritable()` sebelum operasi write
2. Gunakan `getHash()` untuk verifikasi integritas file
3. Gunakan `getHumanSize()` untuk tampilan user-friendly
4. Validasi file gambar dengan `isImage()` dan `getImageDimensions()`
5. Buat backup dengan `copy()` sebelum operasi berbahaya

## ⚠️ Catatan Penting

- Selalu periksa hasil operasi file untuk keamanan
- Gunakan `readSafely()` untuk membaca file besar
- Method `move()` dan `copy()` akan membuat direktori jika belum ada
- Batasi akses file sesuai dengan permissions yang tepat
- Selalu validasi tipe file sebelum memproses
