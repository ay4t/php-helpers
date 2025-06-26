<?php

namespace Ay4t\Helper\Formatter;

/**
 * Mengacu pada main HP class
 * Contoh Penggunaan: 
 * - HP::Phone(string $phone)
 * - HP::Phone(string $phone, string $countryCode)
 * - HP::Phone(string $phone, string $countryCode, string $format)
 */
class Phone implements \Ay4t\Helper\Interfaces\FormatterInterface
{
    /**
     * @var string $phoneNumber
     */
    private $phoneNumber;

    /**
     * jika set True, maka output hanya integer saja. misal : 6285791555506
     * @var boolean
     */
    private $onlyInteger   = false;

    /**
     * @var string $countryCode
     */
    private $countryCode    = 'ID';

    // public function set()
    /**
     * Set phone number
     * 
     * @param string $phoneNumber
     * @param string $countryCode
     * @return self
     */
    public function set( string $phoneNumber, string $countryCode = 'ID' )
    {
        $this->phoneNumber = $phoneNumber;
        $this->countryCode = $countryCode;
        return $this;
    }
    

    /**
     * Tindakan untuk melakukan format 
     * 
     * @param string $phoneNumber
     * @param string $countryCode
     * @return string
     */
    public function getResult() : string
    {   
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        $phoneNumberObject = $phoneUtil->parse( $this->phoneNumber, $this->countryCode);
        
        if( $this->onlyInteger === true ){
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
    public function onlyInteger( bool $onlyInteger ): self
    {
        $this->onlyInteger = $onlyInteger;
        return $this;
    }

}
