<?php

namespace Mouadziani\Mercanet\Concerns;

use InvalidArgumentException;
use Mouadziani\Mercanet\Support\Helper;

trait MercanetResponse
{
    /** @var array */
    private array $responseParameters;

    /** @var string */
    private string $shaSign;

    /**
     * Extract http parameters from given http response
     *
     * @param array $httpResponse
     *
     * @return $this
     */
    public function fromResponse(array $httpResponse): self
    {
        $httpResponse = array_change_key_case($httpResponse, CASE_UPPER);
        $this->shaSign = $this->extractShaSign($httpResponse);
        $this->responseParameters = $this->filterRequestParameters($httpResponse);

        return $this;
    }

    /**
     * Filter http request parameters
     *
     * @param array $httpResponse
     *
     * @return array
     */
    private function filterRequestParameters(array $httpResponse): array
    {
        if (
            ! array_key_exists('DATA', $httpResponse)
            ||
            '' === $httpResponse['DATA']
        ) {
            throw new InvalidArgumentException('Data parameter not present in parameters.');
        }

        $responseParameters = explode('|', $httpResponse['DATA']);
        $parameters = [];

        foreach ($responseParameters as $parameter) {
            $dataKeyValue = explode('=', $parameter, 2);
            $parameters[$dataKeyValue[0]] = $dataKeyValue[1];
        }

        return $parameters;
    }

    /**
     * @param array $responseParameters
     *
     * @return string|null
     */
    private function extractShaSign(array $responseParameters): ?string
    {
        if (
            ! array_key_exists('SEAL', $responseParameters)
            ||
            '' === $responseParameters['SEAL']
        ) {
            throw new InvalidArgumentException('SHASIGN parameter not present in parameters.');
        }

        return $responseParameters['SEAL'];
    }

    /**
     * Retrieves a response parameter
     *
     * @param string $key
     *
     * @return mixed
     */
    public function getParameter(string $key)
    {
        if (method_exists($this, 'get' . $key)) {
            return $this->{'get' . $key}();
        }

        $key = strtoupper($key);
        $parameters = array_change_key_case($this->responseParameters, CASE_UPPER);
        if (! array_key_exists($key, $parameters)) {
            throw new InvalidArgumentException('Parameter ' . $key . ' does not exist.');
        }

        return $parameters[$key];
    }

    /**
     * Checks if the response is valid
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return Helper::generateSHASign($this->responseParameters, $this->secretKey) === $this->shaSign;
    }

    /**
     * Check if the response is passed successful
     *
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return in_array(
            $this->getParameter('RESPONSECODE'),
            ['00', '60'],
            true
        );
    }

    /**
     * Check if payment is successfully passed
     *
     * @return bool
     */
    public function isSuccessfullyPassed(): bool
    {
        return $this->isValid() && $this->isSuccessful();
    }

    /**
     * @return array
     */
    public function getResponseParameters(): array
    {
        return $this->responseParameters;
    }

    /**
     * @return string
     */
    public function getTransactionReference(): string
    {
        return $this->responseParameters['transactionReference'];
    }
}