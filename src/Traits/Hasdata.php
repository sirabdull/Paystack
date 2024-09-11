<?php

namespace Bayscope\Paystack\Traits;

trait Hasdata
{
    /**
     * Array to store transaction data
     *
     * @var array
     */
    protected array $data = [];

    /**
     * Set data for the transaction
     *
     * @param array $data
     * @return $this
     */
    public function setData(array $data): self
    {
        $this->data = array_merge($this->data, $data);
        return $this;
    }

    /**
     * Get all data
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Set a single data item
     *
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function setDataItem(string $key, mixed $value): self
    {
        $this->data[$key] = $value;
        return $this;
    }

    /**
     * Get a single data item
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getDataItem(string $key, mixed $default = null): mixed
    {
        return $this->data[$key] ?? $default;
    }

    /**
     * Check if a data item exists
     *
     * @param string $key
     * @return bool
     */
    public function hasDataItem(string $key): bool
    {
        return isset($this->data[$key]);
    }

    /**
     * Remove a data item
     *
     * @param string $key
     * @return $this
     */
    public function removeDataItem(string $key): self
    {
        unset($this->data[$key]);
        return $this;
    }

    /**
     * Clear all data
     *
     * @return $this
     */
    public function clearData(): self
    {
        $this->data = [];
        return $this;
    }

    /**
     * Common data that can be passed to Paystack endpoints
     *
     * @var array
     */
    protected array $paystackData = [
        'email' => 'Customer email address',
        'amount' => 'Amount in kobo (Nigerian currency)',
        'currency' => 'Transaction currency (e.g., NGN, USD)',
        'reference' => 'Unique transaction reference',
        'callback_url' => 'URL to redirect after payment',
        'plan' => 'Plan code for subscription payments',
        'invoice_limit' => 'Number of times to charge customer',
        'metadata' => 'Additional information as key-value pairs',
        'channels' => 'Payment channels to use (e.g., card, bank)',
        'split_code' => 'Split payment code',
        'subaccount' => 'Subaccount code for split payments',
        'transaction_charge' => 'Additional charge for transaction',
        'bearer' => 'Who bears Paystack charges',
        'first_name' => 'Customer first name',
        'last_name' => 'Customer last name',
        'phone' => 'Customer phone number',
        'custom_fields' => 'Additional custom fields',
        'pay_with_bank' => 'Force payment with bank transfer',
        'bank_code' => 'Bank code for bank payments',
        'bank_account_number' => 'Customer bank account number',
        'bvn' => 'Customer Bank Verification Number',
    ];

    /**
     * Get documentation for Paystack data fields
     *
     * @return array
     */
    public function getPaystackDataDocumentation(): array
    {
        return $this->paystackData;
    }
}
