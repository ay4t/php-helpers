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
    public static function Formatter($formatterName)
    {
        // Tentukan namespace untuk formatter yang sesuai
        $formatterNamespace = "\\Ay4t\\Helper\\Formatter\\{$formatterName}";

        // Buat instance formatter
        return new $formatterNamespace();
    }
}