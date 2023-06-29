<?php

namespace Ay4t\Helper\Lib\Format;

/**
 * Format phone number
 * Trait Class yang berguna untuk memformat nomor telepon sesuai dengan standar internasional
 * menggunakan library libphonenumber-for-php
 */
trait PhoneNumber
{

    /**
     * jika set True, maka output hanya integer saja. misal : 6285791555506
     * @var boolean
     */
    protected static $onlyInteger   = false;

    /**
     * Format phone number
     * 
     * @param string $phoneNumber
     * @param string $countryCode
     * @return string
     */
    public static function phoneNumber( string $phoneNumber, string $countryCode = 'ID' ) : string {
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        $phoneNumberObject = $phoneUtil->parse($phoneNumber, $countryCode);

        if( self::$onlyInteger === true ){
            return $phoneNumberObject->getCountryCode() . $phoneNumberObject->getNationalNumber();            
        }

        return $phoneUtil->format($phoneNumberObject, \libphonenumber\PhoneNumberFormat::INTERNATIONAL);
    }

    /**
     * Set only integer
     * 
     * @param boolean $onlyInteger
     * @return void
     */
    public function setOnlyInteger( bool $onlyInteger ) {
        self::$onlyInteger = $onlyInteger;
    }
}
