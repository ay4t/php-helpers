<?php

// Include the Composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Import all necessary helpers
use Ay4t\Helper\String\StringHelper;
use Ay4t\Helper\Formatter\ArrayHelper;
use Ay4t\Helper\URL\URLHelper;
use Ay4t\Helper\Validation\ValidationHelper;
use Ay4t\Helper\Formatter\Datetime;
use Ay4t\Helper\Security\SecurityHelper;
use Ay4t\Helper\HP;

/**
 * Helper function to print formatted output to the console.
 * @param string $title The header title.
 */
function print_header(string $title)
{
    echo "\n" . str_repeat('=', 50) . "\n";
    echo "--- " . strtoupper($title) . " ---\n";
    echo str_repeat('=', 50) . "\n";
}

/**
 * Helper function to print a key-value result.
 * @param string $description The description of the result.
 * @param mixed $result The result to print.
 */
function print_result(string $description, $result)
{
    echo "- " . str_pad($description, 30) . ": ";
    if (is_bool($result)) {
        echo $result ? 'true' : 'false';
    } elseif (is_array($result) || is_object($result)) {
        echo json_encode($result, JSON_PRETTY_PRINT);
    } else {
        echo $result;
    }
    echo "\n";
}

// --- PhoneHelper Example ---
print_header('PhoneHelper Examples');
$phone = "081234567890";
print_result('Original Phone', $phone);
print_result('Format Default', HP::Phone($phone)->getResult());
print_result('Only Integer', HP::Phone($phone)->onlyInteger(true)->getResult());

// --- CurrencyHelper Example ---
print_header('CurrencyHelper Examples');
$amount = 1250000.75;
print_result('Original Amount', $amount);
print_result('Format IDR (Default)', HP::Currency($amount)->getResult());
print_result('Format USD (2 decimals)', HP::Currency($amount, 'USD', 2)->getResult());
print_result('Format EUR (2 decimals)', HP::Currency($amount, 'EUR', 2)->getResult());
print_result('Amount Counted (Terbilang)', HP::Currency($amount)->counted());


// --- StringHelper Example ---
print_header('StringHelper Examples');
$stringHelper = new StringHelper();
$originalString = "hello world! this is a test.";
print_result('Original String', $originalString);
print_result('Title Case', $stringHelper->set($originalString)->toTitleCase());
print_result('Slugify', $stringHelper->set("Another Example String")->slugify());

// --- ArrayHelper Example ---
print_header('ArrayHelper Examples');
$arrayHelper = new ArrayHelper();
$users = [
    ['id' => 1, 'name' => 'John', 'role' => 'admin'],
    ['id' => 2, 'name' => 'Jane', 'role' => 'editor'],
    ['id' => 3, 'name' => 'Pete', 'role' => 'editor'],
];
print_result('Original Array', $users);
print_result("Pluck 'name'", $arrayHelper->set($users)->pluck('name'));
print_result("Group by 'role'", $arrayHelper->set($users)->groupBy('role'));

// --- URLHelper Example ---
print_header('URLHelper Examples');
$urlHelper = new URLHelper();
$urlHelper->set('https://example.com/path');
print_result('Base URL', $urlHelper->getResult());
$withQuery = $urlHelper->addQueryParams(['user' => '123', 'session' => 'abc']);
print_result('URL with Query', $withQuery);
$urlHelper->set('/another/page.html');
$absolute = $urlHelper->makeAbsolute('https://example.com/base/');
print_result('Absolute URL from relative', $absolute);

// --- ValidationHelper Example ---
print_header('ValidationHelper Examples');
$validationHelper = new ValidationHelper();
$validEmail = 'test@example.com';
$invalidEmail = 'not-an-email';
print_result("Is '{$validEmail}' valid?", $validationHelper->set($validEmail)->isEmail());
print_result("Is '{$invalidEmail}' valid?", $validationHelper->set($invalidEmail)->isEmail());

// --- Datetime Example ---
print_header('Datetime Examples');
$datetime = new Datetime('now', 'UTC');
print_result('Current UTC Time', $datetime->toIso8601String());
print_result('Formatted Datetime', $datetime->format('l, F j, Y H:i:s'));
print_result('Time in Jakarta', $datetime->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s T'));

// --- SecurityHelper Example ---
print_header('SecurityHelper Examples');
$securityHelper = new SecurityHelper();
$token = $securityHelper->generateToken(32);
print_result('Generated Secure Token', $token);
$password = 'my-secret-password';
$hash = $securityHelper->set($password)->hashPassword();
print_result('Hashed Password', $hash);
print_result('Verify correct password', $securityHelper->set($password)->verifyPassword($hash));
print_result('Verify incorrect password', $securityHelper->set('wrong-password')->verifyPassword($hash));

echo "\n";


