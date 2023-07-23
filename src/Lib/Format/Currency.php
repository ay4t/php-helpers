<?php

namespace Ay4t\Helper\Lib\Format;

trait Currency
{
    /**
     * Menggunakan spasi atau tidak pada setelah atau sebelum simbol mata uang
     * @var bool $useSpaceSymbol
     */
    protected static $useSpaceSymbol   = false;

    /**
     * Penempatan simbol mata uang
     * @var string $symbolPlacement prefix|suffix
     */
    protected static $symbolPlacement  = 'suffix';

    /**
     * Format number to currency
     * 
     * @param int|float $amount
     * @param string $symbol
     * @param int $decimal
     * @return string
     */
    public static function currency( int|float $amount = 0, string $symbol = 'IDR', int $decimal = 0 ) : string {
        
        //formatter
        $numberFormatter = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);

        // set number format option
        $numberFormatter->setAttribute(\NumberFormatter::FRACTION_DIGITS, $decimal);

        //money object
        if ($amount instanceof \Money\Money) {
            $currencies = new \Money\Currencies\ISOCurrencies();
            $moneyFormatter = new \Money\Formatter\IntlMoneyFormatter($numberFormatter, $currencies);
            return $moneyFormatter->format($amount);
        }

        // get formatted symbol
        if ( self::$useSpaceSymbol ) {
            $new_symbol = $numberFormatter->getSymbol(\NumberFormatter::CURRENCY_SYMBOL);
            // number format remove symbol
            $numberFormatter->setSymbol(\NumberFormatter::CURRENCY_SYMBOL, '');
            return $new_symbol . ' ' . $numberFormatter->formatCurrency($amount, $symbol);
        }

        return $numberFormatter->formatCurrency($amount, $symbol);

    }

    /**
     * FUngsi untuk merubah nilai angka (integer) menjadi format string terbilang:
     * misal: 1000 menjadi seribu rupiah, 1000000 menjadi satu juta rupiah, dst
     * Support dengan locale [id_ID] coming soon
     */
    public static function terbilang( int $amount = 0, string $locale = 'id_ID' ) : string {
        
        $numberFormatter = new \NumberFormatter($locale, \NumberFormatter::SPELLOUT);
        $numberFormatter->setTextAttribute(\NumberFormatter::DEFAULT_RULESET, "%spellout-numbering-verbose");
        $numberFormatter->setAttribute(\NumberFormatter::FRACTION_DIGITS, 0);

        $terbilang = $numberFormatter->format($amount);
        return $terbilang;
    }

    /**
     * Setter $useSpaceSymbol
     */
    public function setUseSpaceSymbol( bool $useSpaceSymbol ) : bool {
        return self::$useSpaceSymbol = $useSpaceSymbol;
    }
}
