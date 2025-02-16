# 🔗 URL Helper Documentation

URL Helper menyediakan berbagai method untuk memanipulasi dan memvalidasi URL dengan mudah dan aman.

## 📋 Penggunaan Dasar

```php
use Ay4t\Helper\HP;

$url = HP::URL("https://example.com/path?param=value");
```

## 🛠️ Method yang Tersedia

### 1. isValid(bool $strict = false)
Validasi URL.

```php
// Validasi standar
$isValid = HP::URL("https://example.com")->isValid();

// Validasi strict (harus ada path)
$isValid = HP::URL("https://example.com/path")->isValid(true);
```

### 2. getComponent(string $component)
Ambil komponen URL spesifik.

```php
$url = "https://user:pass@example.com:8080/path?query=value#fragment";

$scheme = HP::URL($url)->getComponent('scheme');    // "https"
$host = HP::URL($url)->getComponent('host');        // "example.com"
$port = HP::URL($url)->getComponent('port');        // "8080"
$path = HP::URL($url)->getComponent('path');        // "/path"
$query = HP::URL($url)->getComponent('query');      // "query=value"
$fragment = HP::URL($url)->getComponent('fragment'); // "fragment"
```

### 3. addQueryParams(array $params)
Tambah atau update parameter query.

```php
$url = "https://example.com/search?q=test";

$newUrl = HP::URL($url)->addQueryParams([
    'page' => 1,
    'sort' => 'desc'
]);
// Result: "https://example.com/search?q=test&page=1&sort=desc"
```

### 4. removeQueryParams(array $params)
Hapus parameter query.

```php
$url = "https://example.com/search?q=test&page=1&sort=desc";

$newUrl = HP::URL($url)->removeQueryParams(['page', 'sort']);
// Result: "https://example.com/search?q=test"
```

### 5. getQueryParams()
Ambil semua parameter query sebagai array.

```php
$url = "https://example.com/search?q=test&page=1";

$params = HP::URL($url)->getQueryParams();
// Result: ['q' => 'test', 'page' => '1']
```

### 6. isHttps() & toHttps() & toHttp()
Cek dan konversi protokol.

```php
// Cek HTTPS
$isSecure = HP::URL("https://example.com")->isHttps();

// Konversi ke HTTPS
$secureUrl = HP::URL("http://example.com")->toHttps();

// Konversi ke HTTP
$httpUrl = HP::URL("https://example.com")->toHttp();
```

### 7. getDomain() & getSubdomain()
Ambil domain dan subdomain.

```php
$url = "https://blog.example.com";

$domain = HP::URL($url)->getDomain();     // "example.com"
$subdomain = HP::URL($url)->getSubdomain(); // "blog"
```

### 8. normalize()
Normalisasi URL.

```php
$url = "HTTP://ExaMPle.com:80/path//to/../page/";

$normalized = HP::URL($url)->normalize();
// Result: "http://example.com/path/page/"
```

## 🌟 Contoh Penggunaan Kompleks

### Manipulasi URL Pagination
```php
$url = "https://example.com/products?category=electronics&page=1&sort=price";

$newUrl = HP::URL($url)
    ->removeQueryParams(['page'])
    ->addQueryParams([
        'page' => 2,
        'limit' => 20
    ]);
```

### URL Builder
```php
class UrlBuilder {
    private $baseUrl;

    public function __construct($baseUrl) {
        $this->baseUrl = $baseUrl;
    }

    public function buildApiUrl($endpoint, $params = []) {
        return HP::URL($this->baseUrl)
            ->addQueryParams($params)
            ->makeAbsolute("/api/v1/{$endpoint}");
    }
}
```

## 🔍 Tips Penggunaan

1. Selalu validasi URL sebelum memproses
2. Gunakan `normalize()` untuk konsistensi
3. Gunakan `makeAbsolute()` untuk URL relatif
4. Perhatikan encoding parameter query
5. Gunakan `isHttps()` untuk security checks

## ⚠️ Catatan Penting

- Method `isValid()` mendukung validasi strict
- Semua method menjaga query parameters yang ada
- URL normalization menghapus port default (80/443)
- Subdomain detection mendukung multiple levels
- Semua manipulasi URL bersifat immutable
