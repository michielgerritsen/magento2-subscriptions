<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\DTO;

class CreateMandateResponse
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $payment_method;

    /**
     * @var string
     */
    private $external_id;

    /**
     * @var string
     */
    private $accepted_at;

    /**
     * @var string
     */
    private $created_at;

    /**
     * @var string
     */
    private $updated_at;

    public function __construct(
        $id,
        $status,
        $code,
        $payment_method,
        $external_id,
        $accepted_at,
        $created_at,
        $updated_at
    ) {
        $this->id = $id;
        $this->status = $status;
        $this->code = $code;
        $this->payment_method = $payment_method;
        $this->external_id = $external_id;
        $this->accepted_at = $accepted_at;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public static function fromArray($id, $data): self
    {
        return new static(
            $id,
            $data['status'],
            $data['code'],
            $data['payment_method'],
            $data['external_id'],
            $data['accepted_at'],
            $data['created_at'],
            $data['updated_at']
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
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getPaymentMethod(): string
    {
        return $this->payment_method;
    }

    /**
     * @return string
     */
    public function getExternalId(): string
    {
        return $this->external_id;
    }

    /**
     * @return string
     */
    public function getAcceptedAt(): string
    {
        return $this->accepted_at;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }
}