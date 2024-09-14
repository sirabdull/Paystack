<?php

namespace Bayscope\Paystack\Transaction;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Bayscope\Paystack\Traits\HasData;

class Singlecharge
{
    use HasData;

    protected $client;
    protected $baseUrl = 'https://api.paystack.co';
    protected $secretKey;

    public function __construct($secretKey )
    {
        $this->secretKey = $secretKey;
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]
        ]);
    }

    /**
     * generate random string for transaction reffrence
     * @return string
     */
    public function generateRefference()
    {
        $length = 9;
        return 'TRX_'. strtoupper(bin2hex(random_bytes($length/2)));
    }

    /**
     * Initialize the  transaction
     *
     * @return  {
     *     @var bool $status Transaction initialization status
     *     @var string $message Status message
     *     @var array $data {
     *         @var string $authorization_url URL to redirect customer for payment ( redirect to this Url to complete transaction)
     *         @var string $access_code Access code for the transaction
     *         @var string $reference Unique transaction reference (you can use this to verify transaction)   @method  verifyTransaction(@param string $reffrence)
     *
     *     }
     * }
     */
    public function initialize(): \stdClass | array
    {
        try {
            $response = $this->client->post(uri: '/transaction/initialize', options: [
                'json' => $this->data
            ]);

            return json_decode($response->getBody());
        } catch (RequestException $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Verify a transaction
     *
     * @param string $reference The transaction reference to verify
     * @return array | \stdClass {
     *     @var bool $status Transaction verification status
     *     @var string $message Status message
     *     @var array $data {
     *         @var int $id Transaction ID
     *         @var string $domain Transaction domain (test or live)
     *         @var string $status Transaction status (success, failed, etc.)
     *         @var string $reference Transaction reference
     *         @var int $amount Amount in kobo
     *         @var string $currency Transaction currency
     *         @var string $channel Payment channel used
     *         @var string $paid_at Date and time of payment
     *         @var string $created_at Date and time of transaction creation
     *         @var array $customer Customer details
     *         @var array $authorization Payment authorization details (card) details if payment was made with card
     *         @var array $metadata Additional information stored with the transaction
     *     }
     * }
     */
    public function verifyTransaction($reference): array | \stdClass
    {
        try {
            $response = $this->client->get(uri: '/transaction/verify/' . $reference);

            return json_decode(json: $response->getBody());
        } catch (RequestException $e) {
            return $this->handleException(e: $e);
        }
    }

    /**
     * Handle exceptions from API requests
     *
     * @param RequestException $e The caught exception
     * @return array {
     *     @var bool $status Always false for exceptions
     *     @var string $message Error message
     * }
     */
    protected function handleException(RequestException $e)
    {
        if ($e->hasResponse()) {
            return json_decode(json: $e->getResponse()->getBody(), associative: true);
        }

        return ['status' => false, 'message' => $e->getMessage()];
    }
}
