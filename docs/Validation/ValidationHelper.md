# ✅ Validation Helper Documentation

Validation Helper menyediakan berbagai method untuk memvalidasi data dengan mudah dan fleksibel.

## 📋 Penggunaan Dasar

```php
use Ay4t\Helper\HP;

$validation = HP::Validation();
```

## 🛠️ Method yang Tersedia

### 1. isEmail(bool $checkDNS = false)
Validasi alamat email.

```php
// Validasi format email
$isValid = HP::Validation('user@example.com')->isEmail();

// Validasi dengan pengecekan DNS
$isValid = HP::Validation('user@example.com')->isEmail(true);
```

### 2. isUrl(bool $requireProtocol = true)
Validasi URL.

```php
// URL dengan protocol
$isValid = HP::Validation('https://example.com')->isUrl();

// URL tanpa protocol
$isValid = HP::Validation('example.com')->isUrl(false);
```

### 3. isNumeric(bool $allowNegative = true, bool $allowFloat = true)
Validasi angka.

```php
// Validasi angka dasar
$isValid = HP::Validation('123.45')->isNumeric();

// Hanya angka positif bulat
$isValid = HP::Validation('123')->isNumeric(false, false);
```

### 4. length(int $min, int $max)
Validasi panjang string.

```php
// Validasi panjang username
$isValid = HP::Validation('johndoe')->length(3, 20);

// Validasi panjang password
$isValid = HP::Validation('mypassword123')->length(8, 32);
```

### 5. isStrongPassword()
Validasi kekuatan password.

```php
// Validasi password dengan pengaturan default
$isValid = HP::Validation('MyP@ssw0rd')->isStrongPassword();

// Validasi password dengan pengaturan kustom
$isValid = HP::Validation('MyP@ssw0rd')->isStrongPassword(
    10,    // minimum length
    true,  // require uppercase
    true,  // require lowercase
    true,  // require numbers
    true   // require special chars
);
```

### 6. isCreditCard()
Validasi nomor kartu kredit.

```php
$isValid = HP::Validation('4111111111111111')->isCreditCard();
```

### 7. isPhone(string $pattern = '/^[0-9\-\(\)\/\+\s]*$/')
Validasi nomor telepon.

```php
// Validasi dengan pattern default
$isValid = HP::Validation('+62-812-3456-7890')->isPhone();

// Validasi dengan pattern kustom
$isValid = HP::Validation('08123456789')->isPhone('/^08[0-9]{9,11}$/');
```

### 8. validate(array $data, array $rules)
Validasi multiple field dengan rules.

```php
$data = [
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'age' => 25,
    'website' => 'https://example.com'
];

$rules = [
    'name' => ['required', ['length', 2, 50]],
    'email' => ['required', 'email'],
    'age' => ['required', 'numeric', ['min', 18]],
    'website' => ['url']
];

$validation = HP::Validation();
if (!$validation->validate($data, $rules)) {
    $errors = $validation->getErrors();
    // Handle errors
}
```

## 🌟 Contoh Penggunaan Kompleks

### Form Validation
```php
class UserController {
    public function register($request) {
        $data = [
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
            'age' => $request->age,
            'website' => $request->website
        ];

        $rules = [
            'username' => [
                'required',
                ['length', 3, 20],
                ['regex', '/^[a-zA-Z0-9_]+$/']
            ],
            'email' => [
                'required',
                'email'
            ],
            'password' => [
                'required',
                ['length', 8, 32],
                'isStrongPassword'
            ],
            'age' => [
                'required',
                'numeric',
                ['min', 18]
            ],
            'website' => [
                'url'
            ]
        ];

        $validation = HP::Validation();
        if (!$validation->validate($data, $rules)) {
            return [
                'success' => false,
                'errors' => $validation->getErrors()
            ];
        }

        // Proceed with registration
    }
}
```

### File Upload Validation
```php
class FileController {
    public function upload($file) {
        $validation = HP::Validation($file['tmp_name']);

        // Validasi ukuran file (max 5MB)
        if (!$validation->hasMaxSize(5 * 1024 * 1024)) {
            return 'File terlalu besar';
        }

        // Validasi tipe file
        if (!$validation->hasMimeType(['image/jpeg', 'image/png'])) {
            return 'Tipe file tidak didukung';
        }

        // Validasi ekstensi file
        if (!$validation->hasExtension(['jpg', 'jpeg', 'png'])) {
            return 'Ekstensi file tidak didukung';
        }

        // Proceed with upload
    }
}
```

## 🔍 Tips Penggunaan

1. Gunakan `validate()` untuk validasi multiple field
2. Kombinasikan multiple rules untuk validasi yang kuat
3. Selalu periksa `getErrors()` untuk detail error
4. Gunakan pattern kustom untuk validasi spesifik
5. Manfaatkan validasi file untuk upload yang aman

## ⚠️ Catatan Penting

- Semua validasi bersifat case-sensitive
- Error messages dapat dikustomisasi
- Mendukung validasi nested array
- Validasi file memerlukan akses filesystem
- Gunakan DNS check untuk validasi email yang lebih ketat
