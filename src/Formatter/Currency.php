<?php

// class Currency

namespace Ay4t\Helper\Formatter;

/**
 * Mengacu pada main HP class
 * Contoh Penggunaan: 
 * - HP::Currency(string $amount)
 * - HP::Currency(string $amount, string $currency)
 * - HP::Currency(string $amount, string $currency, int $decimal)
 * - HP::Currency(string $amount)->counted();
 */
class Currency implements \Ay4t\Helper\Interfaces\FormatterInterface
{
    /**
     * @var string $amount
     */
    private $amount;

    /**
     * @var string $currency
     */
    private $currency;

    /**
     * @var int $decimal
     */
    private $decimal;

    /**
     * @var boolean $useSpaceSymbol
     */
    private $useSpaceSymbol = false;

    /**
     * @var string $countedText
     */
    private $countedText;

    /**
     * @var string $locale
     */
    private $locale = 'id_ID';

    /**
     * @var string $result
     */
    private $result;

    /**
     * Set amount
     * 
     * @param string $amount
     * @param string $currency
     * @param int $decimal
     * @return self
     */
    public function set( string $amount, string $currency = 'IDR', int $decimal = 0 )
    {
        $this->amount   = $amount;
        $this->currency = $currency;
        $this->decimal  = $decimal;
        return $this;
    }

    /**
     * Tindakan untuk melakukan format 
     * 
     * @param string $amount
     * @param string $currency
     * @param int $decimal
     * @return string
     */
    public function getResult() : string
    {
        if ( !empty($this->countedText) ) {
            return $this->countedText;
        }

        // formatter
        $numberFormatter = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);

        // set number format option
        $numberFormatter->setAttribute(\NumberFormatter::FRACTION_DIGITS, $this->decimal );

        // get formatted symbol
        if ( $this->useSpaceSymbol ) {
            $new_symbol = $numberFormatter->getSymbol(\NumberFormatter::CURRENCY_SYMBOL);
            // number format remove symbol
            $numberFormatter->setSymbol(\NumberFormatter::CURRENCY_SYMBOL, '');
            return $new_symbol . ' ' . $numberFormatter->formatCurrency( $this->amount , $this->currency );
        }

        return $numberFormatter->formatCurrency( $this->amount, $this->currency );
    }

    /**
     * Fungsi untuk merubah nilai angka (integer) menjadi format string terbilang:
     * misal: 1000 menjadi seribu rupiah, 1000000 menjadi satu juta rupiah, dst
     * Support dengan locale [id_ID] coming soon
     * 
     * @return string
     */
    public function counted() : string
    {
        $numberFormatter = new \NumberFormatter($this->locale, \NumberFormatter::SPELLOUT);
        $numberFormatter->setTextAttribute(\NumberFormatter::DEFAULT_RULESET, "%spellout-numbering-verbose");
        $numberFormatter->setAttribute(\NumberFormatter::FRACTION_DIGITS, 0);

        $this->countedText = $numberFormatter->format($this->amount);
        return $this->countedText;
    }
}