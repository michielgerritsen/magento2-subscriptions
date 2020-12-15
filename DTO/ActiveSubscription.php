<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\DTO;

class ActiveSubscription
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var SubscriptionPlan
     */
    private $plan;

    /**
     * @var string
     */
    private $mandate_code;

    /**
     * @var bool
     */
    private $mandate_accepted;

    /**
     * @var string
     */
    private $mandate_accepted_date;

    /**
     * @var string
     */
    private $start_date;

    /**
     * @var string
     */
    private $status;

    /**
     * @var null
     */
    private $cancel_date;

    /**
     * @var null
     */
    private $resume_date;

    /**
     * @var string
     */
    private $confirmation_page;

    /**
     * @var bool
     */
    private $confirmation_sent;

    /**
     * @var string
     */
    private $subscription_webhook_url;

    /**
     * @var string
     */
    private $transaction_webhook_url;

    /**
     * @var null
     */
    private $success_redirect_url;

    /**
     * @var null
     */
    private $metadata;

    /**
     * @var bool
     */
    private $archived;

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
        SubscriptionPlan $plan,
        $mandate_code,
        $mandate_accepted,
        $mandate_accepted_date,
        $start_date,
        $status,
        $cancel_date = null,
        $resume_date = null,
        $confirmation_page,
        $confirmation_sent,
        $subscription_webhook_url,
        $transaction_webhook_url,
        $success_redirect_url = null,
        $metadata = null,
        $archived,
        $created_at,
        $updated_at
    ) {
        $this->id = $id;
        $this->plan = $plan;
        $this->mandate_code = $mandate_code;
        $this->mandate_accepted = $mandate_accepted;
        $this->mandate_accepted_date = $mandate_accepted_date;
        $this->start_date = $start_date;
        $this->status = $status;
        $this->cancel_date = $cancel_date;
        $this->resume_date = $resume_date;
        $this->confirmation_page = $confirmation_page;
        $this->confirmation_sent = $confirmation_sent;
        $this->subscription_webhook_url = $subscription_webhook_url;
        $this->transaction_webhook_url = $transaction_webhook_url;
        $this->success_redirect_url = $success_redirect_url;
        $this->metadata = $metadata;
        $this->archived = $archived;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public static function fromArray($id, SubscriptionPlan $plan, $data): self
    {
        return new static(
            $id,
            $plan,
            $data['mandate_code'],
            $data['mandate_accepted'],
            $data['mandate_accepted_date'],
            $data['start_date'],
            $data['status'],
            $data['cancel_date'],
            $data['resume_date'],
            $data['confirmation_page'],
            $data['confirmation_sent'],
            $data['subscription_webhook_url'],
            $data['transaction_webhook_url'],
            $data['success_redirect_url'],
            $data['metadata'],
            $data['archived'],
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
     * @return SubscriptionPlan
     */
    public function getPlan(): SubscriptionPlan
    {
        return $this->plan;
    }

    /**
     * @return string
     */
    public function getMandateCode(): string
    {
        return $this->mandate_code;
    }

    /**
     * @return bool
     */
    public function isMandateAccepted(): bool
    {
        return $this->mandate_accepted;
    }

    /**
     * @return string
     */
    public function getMandateAcceptedDate(): string
    {
        return $this->mandate_accepted_date;
    }

    /**
     * @return string
     */
    public function getStartDate(): string
    {
        return $this->start_date;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return null
     */
    public function getCancelDate()
    {
        return $this->cancel_date;
    }

    /**
     * @return null
     */
    public function getResumeDate()
    {
        return $this->resume_date;
    }

    /**
     * @return string
     */
    public function getConfirmationPage(): string
    {
        return $this->confirmation_page;
    }

    /**
     * @return bool
     */
    public function isConfirmationSent(): bool
    {
        return $this->confirmation_sent;
    }

    /**
     * @return string
     */
    public function getSubscriptionWebhookUrl(): string
    {
        return $this->subscription_webhook_url;
    }

    /**
     * @return string
     */
    public function getTransactionWebhookUrl(): string
    {
        return $this->transaction_webhook_url;
    }

    /**
     * @return null
     */
    public function getSuccessRedirectUrl()
    {
        return $this->success_redirect_url;
    }

    /**
     * @return null
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @return bool
     */
    public function isArchived(): bool
    {
        return $this->archived;
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