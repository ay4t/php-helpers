# 🔒 Security Helper Documentation

Security Helper menyediakan berbagai method untuk keamanan aplikasi, termasuk hashing password, enkripsi data, dan generasi token.

## 📋 Penggunaan Dasar

```php
use Ay4t\Helper\HP;

$security = HP::Security();
```

## 🛠️ Method yang Tersedia

### 1. hashPassword(array $options = [])
Hash password dengan aman menggunakan Argon2id.

```php
$password = "mySecurePassword123";
$hash = HP::Security($password)->hashPassword();

// Dengan opsi kustom
$hash = HP::Security($password)->hashPassword([
    'memory_cost' => 65536,
    'time_cost' => 4,
    'threads' => 3
]);
```

### 2. verifyPassword(string $hash)
Verifikasi password dengan hash.

```php
$password = "mySecurePassword123";
$isValid = HP::Security($password)->verifyPassword($hash);
```

### 3. generateToken(int $length = 32, bool $urlSafe = true)
Generate token acak yang aman.

```php
// Token URL-safe
$token = HP::Security()->generateToken();

// Token hex
$token = HP::Security()->generateToken(32, false);
```

### 4. generateApiKey(string $prefix = '')
Generate API key yang aman.

```php
// API key tanpa prefix
$apiKey = HP::Security()->generateApiKey();

// API key dengan prefix
$apiKey = HP::Security()->generateApiKey('user');
// Result: "user_a1b2c3d4..."
```

### 5. encrypt(string $key, string $method = 'aes-256-cbc')
Enkripsi data menggunakan OpenSSL.

```php
$data = "Sensitive data";
$key = "your-secret-key";

$encrypted = HP::Security($data)->encrypt($key);
```

### 6. decrypt(string $key, string $method = 'aes-256-cbc')
Dekripsi data yang terenkripsi.

```php
$decrypted = HP::Security($encrypted)->decrypt($key);
```

### 7. generateCsrfToken() & verifyCsrfToken(string $token)
Manajemen token CSRF.

```php
// Generate token
$token = HP::Security()->generateCsrfToken();

// Verifikasi token
$isValid = HP::Security()->verifyCsrfToken($_POST['csrf_token']);
```

### 8. generatePassword(int $length = 12, bool $special = true, bool $extra = false)
Generate password acak yang aman.

```php
// Password standar
$password = HP::Security()->generatePassword();

// Password dengan karakter khusus tambahan
$password = HP::Security()->generatePassword(16, true, true);
```

## 🌟 Contoh Penggunaan Kompleks

### Sistem Autentikasi
```php
class Auth {
    public function register($username, $password) {
        // Hash password
        $hash = HP::Security($password)->hashPassword();
        
        // Generate API key
        $apiKey = HP::Security()->generateApiKey('user');
        
        // Simpan ke database...
    }

    public function login($username, $password) {
        // Ambil hash dari database...
        $hash = '...';
        
        // Verifikasi password
        return HP::Security($password)->verifyPassword($hash);
    }
}
```

### Enkripsi Data Sensitif
```php
// Enkripsi data
$sensitiveData = [
    'cc_number' => '4111111111111111',
    'exp_date' => '12/25'
];

$key = getenv('ENCRYPTION_KEY');
$encrypted = HP::Security(json_encode($sensitiveData))->encrypt($key);

// Dekripsi data
$decrypted = HP::Security($encrypted)->decrypt($key);
$data = json_decode($decrypted, true);
```

## 🔍 Tips Penggunaan

1. Selalu gunakan `hashPassword()` untuk menyimpan password
2. Gunakan `generateToken()` untuk session tokens
3. Implementasikan CSRF protection di semua form
4. Simpan encryption keys di environment variables
5. Gunakan `generatePassword()` untuk temporary passwords

## ⚠️ Catatan Penting

- Default menggunakan Argon2id untuk hashing password
- Enkripsi menggunakan AES-256-CBC secara default
- CSRF tokens disimpan dalam session
- Semua method menggunakan secure random number generator
- Perhatikan keamanan dalam menyimpan encryption keys
