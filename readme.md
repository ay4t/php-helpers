# Contoh Penggunaan
Berikut ini adalah contoh penggunaan dari package helper ini.

## Contoh Format PhoneNumber
```php
$helper = HP::Formatter('Phone');
$helper->set('085791555506', 'ID');

// jika Anda ingin mengambil hanya integer saja, maka gunakan method onlyInteger()
$helper->onlyInteger(true);

// untuk mendapatkan hasil format, gunakan method getResult()
$result = $helper->getResult();
var_dump( $result );
```

## Contoh Format Currency
```php

$helper = HP::Formatter('Currency');
$helper->set('3123123', 'IDR', 2);

// jika anda ingin mengubah menjadi fungsi terbilang tambahkan fungsi berikut
$helper->counted();

$result = $helper->getResult();
var_dump( $result ); 
```

## Contoh Format Date
Class helper ini hanya wrapper dari Carbon. Semua contoh dan cara penggunaan mengikuti : https://carbon.nesbot.com/docs/
```php
$helper = HP::Formatter('Datetime');
$result     = $helper::now()->toDateTimeString();
var_dump( $result );
```
Contoh untuk penambahan hari
```php
$helper = HP::Formatter('Datetime');
$helper::now();
$helper->add(1, 'day');
$result     = $helper->toDateTimeString();
// atau
$result     = $helper->format('Y-m-d H:i:s');
// atau
$result     = $helper->isoFormat('dddd D');
var_dump( $result );
```
# Installasi
Untuk menginstall package ini, gunakan perintah berikut ini
```bash
composer config minimum-stability dev ( ini optional jika anda ingin menginstall versi dev )
composer config repositories.phphelpers vcs git@github.com:ay4t/php-helpers.git
composer require ay4t/php-helpers
```

# Kontribusi
Jika Anda ingin berkontribusi pada package ini, silahkan fork repository ini, lakukan perubahan, dan buat pull request ke repository ini. Saya akan sangat senang jika Anda berkontribusi pada package ini.