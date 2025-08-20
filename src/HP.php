<?php

namespace Ay4t\Helper;

/**
 * Helper PHP Class
 * Contoh Penggunaan: 
 * - HP::Phone(string $phone)
 * - HP::Phone(string $phone, string $countryCode)
 * - HP::Phone(string $phone, string $countryCode, string $format)
 * 
 * - HP::Currency(string $amount)
 * - HP::Currency(string $amount, string $currency)
 * - HP::Currency(string $amount, string $currency, int $decimal)
 * - HP::Currency(string $amount)->counted();
 */
class HP
{
    /**
     * Magic method to dynamically call helper classes.
     *
     * @param string $name      The name of the helper class (e.g., 'Phone', 'Currency').
     * @param array  $arguments The arguments to pass to the helper's `set` or constructor method.
     * @return object The helper instance.
     */
    public static function __callStatic($name, $arguments)
    {
        // Define potential namespaces
        $namespaces = [
            'Ay4t\\Helper\\Formatter\\',
            'Ay4t\\Helper\\String\\',
            'Ay4t\\Helper\\File\\',
            'Ay4t\\Helper\\HTML\\',
            'Ay4t\\Helper\\Security\\',
            'Ay4t\\Helper\\URL\\',
            'Ay4t\\Helper\\Validation\\',
        ];

        // Define possible class name patterns
        $classPatterns = [
            ucfirst($name),
            ucfirst($name) . 'Helper',
        ];

        $foundClass = null;
        foreach ($namespaces as $namespace) {
            foreach ($classPatterns as $classPattern) {
                $fullClassName = $namespace . $classPattern;
                if (class_exists($fullClassName)) {
                    $foundClass = $fullClassName;
                    break 2;
                }
            }
        }

        if (!$foundClass) {
            throw new \BadMethodCallException("Helper '{$name}' not found.");
        }

        $reflection = new \ReflectionClass($foundClass);

        // If a 'set' method exists, we instantiate without constructor args and then call 'set'.
        if ($reflection->hasMethod('set')) {
            $instance = $reflection->newInstance();
            return $instance->set(...$arguments);
        }
        
        // Otherwise, we pass the arguments to the constructor.
        return $reflection->newInstanceArgs($arguments);
    }
}