<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\DTO;

class CreateCustomerResponse
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $first_name;

    /**
     * @var string
     */
    private $last_name;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string|null
     */
    private $gender;

    /**
     * @var string|null
     */
    private $middle_name;

    /**
     * @var string|null
     */
    private $company_name;

    /**
     * @var string|null
     */
    private $vat_number;

    /**
     * @var string|null
     */
    private $bank_holder;

    /**
     * @var string|null
     */
    private $iban;

    /**
     * @var string|null
     */
    private $payment_method;

    /**
     * @var string|null
     */
    private $bank_verification_method;

    /**
     * @var string|null
     */
    private $card_holder;

    /**
     * @var string|null
     */
    private $card_number;

    /**
     * @var string|null
     */
    private $postalcode;

    /**
     * @var string|null
     */
    private $house_number;

    /**
     * @var string|null
     */
    private $house_number_add;

    /**
     * @var string|null
     */
    private $street;

    /**
     * @var string|null
     */
    private $city;

    /**
     * @var string|null
     */
    private $country_iso2;

    /**
     * @var string|null
     */
    private $telephone;

    /**
     * @var string|null
     */
    private $language;

    /**
     * @var string|null
     */
    private $archived;

    /**
     * @var string|null
     */
    private $created_at;

    /**
     * @var string|null
     */
    private $updated_at;

    public function __construct(
        $id,
        $first_name,
        $last_name,
        $email,
        $gender = null,
        $middle_name = null,
        $company_name = null,
        $vat_number = null,
        $bank_holder = null,
        $iban = null,
        $payment_method = null,
        $bank_verification_method = null,
        $card_holder = null,
        $card_number = null,
        $postalcode = null,
        $house_number = null,
        $house_number_add = null,
        $street = null,
        $city = null,
        $country_iso2 = null,
        $telephone = null,
        $language = null,
        $archived = null,
        $created_at = null,
        $updated_at = null
    ) {
        $this->id = $id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->gender = $gender;
        $this->middle_name = $middle_name;
        $this->company_name = $company_name;
        $this->vat_number = $vat_number;
        $this->bank_holder = $bank_holder;
        $this->iban = $iban;
        $this->payment_method = $payment_method;
        $this->bank_verification_method = $bank_verification_method;
        $this->card_holder = $card_holder;
        $this->card_number = $card_number;
        $this->postalcode = $postalcode;
        $this->house_number = $house_number;
        $this->house_number_add = $house_number_add;
        $this->street = $street;
        $this->city = $city;
        $this->country_iso2 = $country_iso2;
        $this->telephone = $telephone;
        $this->language = $language;
        $this->archived = $archived;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public static function fromArray($id, $data): self
    {
        return new static(
            $id,
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['gender'] ?? null,
            $data['middle_name'] ?? null,
            $data['company_name'] ?? null,
            $data['vat_number'] ?? null,
            $data['bank_holder'] ?? null,
            $data['iban'] ?? null,
            $data['payment_method'] ?? null,
            $data['bank_verification_method'] ?? null,
            $data['card_holder'] ?? null,
            $data['card_number'] ?? null,
            $data['postalcode'] ?? null,
            $data['house_number'] ?? null,
            $data['house_number_add'] ?? null,
            $data['street'] ?? null,
            $data['city'] ?? null,
            $data['country_iso2'] ?? null,
            $data['telephone'] ?? null,
            $data['language'] ?? null,
            $data['archived'] ?? null,
            $data['created_at'] ?? null,
            $data['updated_at'] ?? null
        );
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @return string|null
     */
    public function getMiddleName(): ?string
    {
        return $this->middle_name;
    }

    /**
     * @return string|null
     */
    public function getCompanyName(): ?string
    {
        return $this->company_name;
    }

    /**
     * @return string|null
     */
    public function getVatNumber(): ?string
    {
        return $this->vat_number;
    }

    /**
     * @return string|null
     */
    public function getBankHolder(): ?string
    {
        return $this->bank_holder;
    }

    /**
     * @return string|null
     */
    public function getIban(): ?string
    {
        return $this->iban;
    }

    /**
     * @return string|null
     */
    public function getPaymentMethod(): ?string
    {
        return $this->payment_method;
    }

    /**
     * @return string|null
     */
    public function getBankVerificationMethod(): ?string
    {
        return $this->bank_verification_method;
    }

    /**
     * @return string|null
     */
    public function getCardHolder(): ?string
    {
        return $this->card_holder;
    }

    /**
     * @return string|null
     */
    public function getCardNumber(): ?string
    {
        return $this->card_number;
    }

    /**
     * @return string|null
     */
    public function getPostalcode(): ?string
    {
        return $this->postalcode;
    }

    /**
     * @return string|null
     */
    public function getHouseNumber(): ?string
    {
        return $this->house_number;
    }

    /**
     * @return string|null
     */
    public function getHouseNumberAdd(): ?string
    {
        return $this->house_number_add;
    }

    /**
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @return string|null
     */
    public function getCountryIso2(): ?string
    {
        return $this->country_iso2;
    }

    /**
     * @return string|null
     */
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    /**
     * @return string|null
     */
    public function getLanguage(): ?string
    {
        return $this->language;
    }

    /**
     * @return string|null
     */
    public function getArchived(): ?string
    {
        return $this->archived;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updated_at;
    }
}