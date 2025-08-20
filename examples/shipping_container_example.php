<?php

// Example CLI for ShippingContainerChecker
// Usage:
//   php examples/shipping_container_example.php [CONTAINER ...]
// If no arguments provided, a default set will be demonstrated.

require_once __DIR__ . '/../vendor/autoload.php';

use Ay4t\Helper\HP;

function clean($s) {
    return preg_replace('/\s+/', ' ', trim($s));
}

function process_input(string $input): void {
    $raw = $input;
    $normalized = strtoupper(preg_replace('/[^A-Z0-9]/i', '', $raw));
    $hasCheck = strlen($normalized) >= 11; // 4 letters + 6 digits + (optional) 1 check

    echo "\n=== Input: " . clean($raw) . " ===\n";

    try {
        $checker = HP::ShippingContainerChecker($raw);
        if ($hasCheck) {
            $valid = $checker->isValid();
            $expected = $checker->expectedCheckDigit();
            $result = $checker->getResult();
            $given = substr($normalized, 10, 1);

            echo "Normalized : {$result}\n";
            echo "Given Check: {$given}\n";
            echo "Expected   : {$expected}\n";
            echo "Valid      : " . ($valid ? 'YES' : 'NO') . "\n";
        } else {
            $expected = $checker->expectedCheckDigit();
            $result = $checker->getResult();

            echo "Normalized : {$result}\n";
            echo "Expected   : {$expected}\n";
            echo "Info       : (No check digit provided in input)\n";
        }
    } catch (Throwable $e) {
        echo "Error      : " . $e->getMessage() . "\n";
    }
}

$args = $argv;
array_shift($args); // remove script name

if (count($args) === 0) {
    $samples = [
        'CSQU3054383',      // valid full
        'CSQU 305438 3',    // valid with spaces
        'CSQU305438',       // without check digit -> expect 3
        'CSQU3054384',      // invalid check digit (should be 3)
        'MSKU123456',       // compute expected digit for sample
        'ABCU12X4567',      // invalid: serial contains non-digit
        'ABC13054383',      // invalid: 4th char must be a letter (category)
    ];
    foreach ($samples as $s) {
        process_input($s);
    }
    echo "\nTip: You can pass your own inputs, e.g.\n";
    echo "  php examples/shipping_container_example.php MSKU123456 CSQU3054383 \"CSQU 305438 3\"\n";
} else {
    foreach ($args as $a) {
        process_input($a);
    }
}
