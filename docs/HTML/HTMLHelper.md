# 🌐 HTML Helper Documentation

HTML Helper menyediakan method untuk membuat dan memanipulasi elemen HTML dengan aman dan mudah.

## 📋 Penggunaan Dasar

```php
use Ay4t\Helper\HP;

$html = HP::HTML();
```

## 🛠️ Method yang Tersedia

### 1. element(string $tag, array $attributes = [], string $content = null)
Membuat elemen HTML.

```php
// Elemen dasar
$div = HP::HTML("Content")->element('div', ['class' => 'container']);

// Elemen dengan multiple attributes
$p = HP::HTML("Text")->element('p', [
    'class' => 'text-primary',
    'id' => 'paragraph-1',
    'data-custom' => 'value'
]);
```

### 2. link(string $href, string $text = null, array $attributes = [])
Membuat elemen link.

```php
// Link dasar
$link = HP::HTML()->link('https://example.com', 'Visit Website');

// Link dengan attributes
$link = HP::HTML()->link('https://example.com', 'Visit Website', [
    'class' => 'btn btn-primary',
    'target' => '_blank'
]);
```

### 3. image(string $src, string $alt = '', array $attributes = [])
Membuat elemen gambar.

```php
// Image dasar
$img = HP::HTML()->image('path/to/image.jpg', 'Description');

// Image dengan attributes
$img = HP::HTML()->image('path/to/image.jpg', 'Description', [
    'class' => 'img-fluid',
    'width' => 300
]);
```

### 4. form(string $action, string $method = 'POST', array $attributes = [])
Membuat elemen form.

```php
// Form dasar
$form = HP::HTML($formContent)->form('/submit', 'POST');

// Form dengan attributes
$form = HP::HTML($formContent)->form('/submit', 'POST', [
    'class' => 'needs-validation',
    'novalidate' => true
]);
```

### 5. input(string $type, string $name, string $value = '', array $attributes = [])
Membuat elemen input.

```php
// Input text
$input = HP::HTML()->input('text', 'username', '', [
    'class' => 'form-control',
    'required' => true
]);

// Input dengan validasi
$input = HP::HTML()->input('email', 'email', '', [
    'class' => 'form-control',
    'required' => true,
    'pattern' => '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$'
]);
```

### 6. select(string $name, array $options, $selected = '', array $attributes = [])
Membuat elemen select.

```php
$options = [
    'id' => 'ID',
    'my' => 'Malaysia',
    'sg' => 'Singapore'
];

// Select dasar
$select = HP::HTML()->select('country', $options, 'id');

// Multiple select
$select = HP::HTML()->select('countries[]', $options, ['id', 'sg'], [
    'multiple' => true,
    'class' => 'form-select'
]);
```

### 7. textarea(string $name, string $value = '', array $attributes = [])
Membuat elemen textarea.

```php
// Textarea dasar
$textarea = HP::HTML()->textarea('message', 'Initial content');

// Textarea dengan attributes
$textarea = HP::HTML()->textarea('message', 'Initial content', [
    'class' => 'form-control',
    'rows' => 5
]);
```

### 8. table(array $data, array $headers = null, array $attributes = [])
Membuat elemen table.

```php
$data = [
    ['John', 'john@example.com', 25],
    ['Jane', 'jane@example.com', 28]
];

$headers = ['Name', 'Email', 'Age'];

// Table dengan headers
$table = HP::HTML()->table($data, $headers, [
    'class' => 'table table-striped'
]);
```

## 🌟 Contoh Penggunaan Kompleks

### Form Builder
```php
$formContent = 
    HP::HTML()->input('text', 'name', '', ['required' => true]) .
    HP::HTML()->input('email', 'email', '', ['required' => true]) .
    HP::HTML()->textarea('message', '', ['rows' => 5]) .
    HP::HTML()->button('Submit', 'submit', ['class' => 'btn btn-primary']);

$form = HP::HTML($formContent)->form('/submit', 'POST', [
    'class' => 'needs-validation',
    'novalidate' => true
]);
```

### Card Component
```php
$cardHeader = HP::HTML('Card Title')->element('h5', ['class' => 'card-title']);
$cardBody = HP::HTML('Card content')->element('p', ['class' => 'card-text']);
$cardLink = HP::HTML()->link('#', 'Read More', ['class' => 'btn btn-primary']);

$cardContent = $cardHeader . $cardBody . $cardLink;

$card = HP::HTML($cardContent)->element('div', ['class' => 'card']);
```

## 🔍 Tips Penggunaan

1. Selalu gunakan `escape()` untuk konten yang tidak terpercaya
2. Gunakan method khusus untuk elemen umum (link, image, form, dll)
3. Manfaatkan method chaining untuk kode yang lebih bersih
4. Perhatikan void elements yang tidak memerlukan closing tag
5. Gunakan attributes untuk styling dan JavaScript hooks

## ⚠️ Catatan Penting

- Semua output HTML di-escape secara otomatis
- Mendukung HTML5 void elements
- Attributes boolean ditangani dengan benar
- Method dapat digunakan secara bertingkat
- Mengikuti standar W3C untuk pembuatan HTML
