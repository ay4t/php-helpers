# Array Helper Documentation

Array Helper adalah kelas yang menyediakan berbagai fungsi untuk memanipulasi dan mengolah array di PHP dengan cara yang lebih mudah dan ekspresif. Helper ini dapat digunakan untuk berbagai keperluan seperti transformasi data, filtering, sorting, dan operasi array lainnya.

## Instalasi

```bash
composer require ay4t/php-helpers
```

## Penggunaan Dasar

Untuk menggunakan Array Helper, Anda dapat menggunakan facade `HP` seperti berikut:

```php
use Ay4t\Helper\HP;

$array = [...]; // array Anda
$result = HP::Array($array)->methodName();
```

## Method yang Tersedia

### 1. flatten()

Mengubah array multi-dimensi menjadi array satu dimensi.

```php
$array = [1, [2, 3], [4, [5, 6]]];
$result = HP::Array($array)->flatten();

// Result:
[1, 2, 3, 4, 5, 6]
```

### 2. groupBy(string $key)

Mengelompokkan array berdasarkan key tertentu.

```php
$users = [
    ['role' => 'admin', 'name' => 'John'],
    ['role' => 'user', 'name' => 'Jane'],
    ['role' => 'admin', 'name' => 'Bob']
];

$result = HP::Array($users)->groupBy('role');

// Result:
[
    'admin' => [
        ['role' => 'admin', 'name' => 'John'],
        ['role' => 'admin', 'name' => 'Bob']
    ],
    'user' => [
        ['role' => 'user', 'name' => 'Jane']
    ]
]
```

### 3. pluck(string $field)

Mengambil nilai dari key tertentu dalam array.

```php
$users = [
    ['id' => 1, 'name' => 'John'],
    ['id' => 2, 'name' => 'Jane']
];

$result = HP::Array($users)->pluck('name');

// Result:
['John', 'Jane']
```

### 4. where(string $field, mixed $value)

Mencari data dalam array berdasarkan kondisi.

```php
$users = [
    ['role' => 'admin', 'name' => 'John'],
    ['role' => 'user', 'name' => 'Jane'],
    ['role' => 'admin', 'name' => 'Bob']
];

$result = HP::Array($users)->where('role', 'admin');

// Result:
[
    ['role' => 'admin', 'name' => 'John'],
    ['role' => 'admin', 'name' => 'Bob']
]
```

### 5. sortBy(string $field, string $direction = 'asc')

Mengurutkan array berdasarkan key tertentu.

```php
$users = [
    ['name' => 'John', 'age' => 30],
    ['name' => 'Jane', 'age' => 25],
    ['name' => 'Bob', 'age' => 35]
];

// Ascending order (default)
$result = HP::Array($users)->sortBy('age');

// Result:
[
    ['name' => 'Jane', 'age' => 25],
    ['name' => 'John', 'age' => 30],
    ['name' => 'Bob', 'age' => 35]
]

// Descending order
$result = HP::Array($users)->sortBy('age', 'desc');

// Result:
[
    ['name' => 'Bob', 'age' => 35],
    ['name' => 'John', 'age' => 30],
    ['name' => 'Jane', 'age' => 25]
]
```

### 6. unique(string $field = null)

Menghapus nilai duplikat dalam array.

```php
// Simple array
$numbers = [1, 2, 2, 3, 3, 4];
$result = HP::Array($numbers)->unique();

// Result:
[1, 2, 3, 4]

// Array of objects/arrays with field
$users = [
    ['id' => 1, 'role' => 'admin'],
    ['id' => 2, 'role' => 'admin'],
    ['id' => 3, 'role' => 'user']
];

$result = HP::Array($users)->unique('role');

// Result:
[
    ['id' => 1, 'role' => 'admin'],
    ['id' => 3, 'role' => 'user']
]
```

### 7. chunk(int $size)

Membagi array menjadi beberapa bagian dengan ukuran yang sama.

```php
$array = [1, 2, 3, 4, 5, 6];
$result = HP::Array($array)->chunk(2);

// Result:
[
    [1, 2],
    [3, 4],
    [5, 6]
]
```

### 8. search(string $needle, string $field = null)

Mencari nilai dalam array (case-insensitive).

```php
// Simple array
$fruits = ['Apple', 'Banana', 'Orange', 'Pineapple'];
$result = HP::Array($fruits)->search('apple');

// Result:
['Apple', 'Pineapple']

// Array of objects/arrays with field
$users = [
    ['name' => 'John Doe', 'email' => 'john@example.com'],
    ['name' => 'Jane Doe', 'email' => 'jane@example.com']
];

$result = HP::Array($users)->search('john', 'name');

// Result:
[
    ['name' => 'John Doe', 'email' => 'john@example.com']
]
```

### 9. implode(string $delimiter = ',', string $field = null)

Mengubah array menjadi string dengan delimiter tertentu.

```php
// Simple array
$fruits = ['apple', 'banana', 'orange'];
$result = HP::Array($fruits)->implode(', ');

// Result:
"apple, banana, orange"

// Array of objects/arrays with field
$users = [
    ['name' => 'John', 'age' => 30],
    ['name' => 'Jane', 'age' => 25]
];

$result = HP::Array($users)->implode(', ', 'name');

// Result:
"John, Jane"
```

## Method Chaining

Anda dapat menggabungkan beberapa method sekaligus untuk melakukan operasi yang lebih kompleks:

```php
$users = [
    ['role' => 'admin', 'name' => 'John', 'active' => true],
    ['role' => 'admin', 'name' => 'Jane', 'active' => false],
    ['role' => 'user', 'name' => 'Bob', 'active' => true],
    ['role' => 'user', 'name' => 'Alice', 'active' => true]
];

$result = HP::Array($users)
    ->where('active', true)
    ->sortBy('name')
    ->pluck('name')
    ->implode(', ');

// Result:
"Alice, Bob, John"
```

## Penggunaan dengan Data dari Database

Array Helper sangat berguna ketika bekerja dengan data dari database:

```php
// Contoh data dari database
$orders = [
    ['status' => 'pending', 'total' => 100, 'customer' => 'John'],
    ['status' => 'completed', 'total' => 200, 'customer' => 'Jane'],
    ['status' => 'pending', 'total' => 150, 'customer' => 'Bob'],
    ['status' => 'completed', 'total' => 300, 'customer' => 'Alice']
];

// Mendapatkan total pesanan yang pending
$pendingOrders = HP::Array($orders)
    ->where('status', 'pending')
    ->sortBy('total', 'desc');

// Mendapatkan daftar customer yang memiliki pesanan completed
$completedCustomers = HP::Array($orders)
    ->where('status', 'completed')
    ->pluck('customer')
    ->implode(', ');
```

## Tips Penggunaan

1. Gunakan method chaining untuk membuat kode lebih ringkas dan mudah dibaca
2. Manfaatkan parameter opsional seperti `$field` pada method `unique()` dan `search()`
3. Perhatikan tipe data yang diproses, terutama saat menggunakan method seperti `sortBy()`
4. Gunakan method yang sesuai untuk performa yang lebih baik (misalnya `pluck()` vs `where()->implode()`)

## Kontribusi

Jika Anda menemukan bug atau ingin menambahkan fitur baru, silakan buat issue atau pull request di repository GitHub kami.