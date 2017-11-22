<?php

namespace MatthewErskine\Client;

use GuzzleHttp\Client as GuzzleClient;

class Client
{
    /**
     * The URL of the resource.
     *
     * @var string
     */
    protected $url;

    /**
     * Guzzle configuration options.
     *
     * @var array
     */
    protected $guzzle;

    /**
     * The Guzzle client instance.
     *
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * The last response received.
     *
     * @var \GuzzleHttp\Psr7\Response
     */
    protected $lastResponse;

    /**
     * Called when the class should load.
     *
     * @param string $url
     * @param \GuzzleHttp\Client $httpClient
     * @param array $guzzle
     */
    public function __construct($url, GuzzleClient $httpClient, $guzzle = [])
    {
        $this->url = $url;
        $this->guzzle = $guzzle;
        $this->httpClient = $httpClient;
    }

    /**
     * Gets the URL of the resource.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Sets the URL of the resource.
     *
     * @param string $url
     * @return self
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Gets the Guzzle configuration options.
     *
     * @return array
     */
    public function getGuzzle()
    {
        return $this->guzzle;
    }

    /**
     * Sets the Guzzle configuration options.
     *
     * @param array $guzzle
     * @return self
     */
    public function setGuzzle(array $guzzle)
    {
        $this->guzzle = $guzzle;

        return $this;
    }

    /**
     * Gets the Guzzle HTTP Client instance.
     *
     * @return \GuzzleHttp\Client
     */
    public function getHttpClient()
    {
        if (is_null($this->httpClient)) {
            $this->httpClient = new GuzzleClient(
                $this->getGuzzle()
            );
        }

        return $this->httpClient;
    }

    /**
     * Sets the Guzzle HTTP Client instance.
     *
     * @param \GuzzleHttp\Client $httpClient
     * @return self
     */
    public function setHttpClient(GuzzleClient $httpClient)
    {
        $this->httpClient = $httpClient;

        return $this;
    }

    /**
     * Gets the last response.
     *
     * @return \GuzzleHttp\Psr7\Response
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * Sets the last response.
     *
     * @param \GuzzleHttp\Psr7\Response $lastResponse
     * @return self
     */
    public function setLastResponse($lastResponse)
    {
        $this->lastResponse = $lastResponse;

        return $this;
    }

    /**
     * Checks the health of the associated service.
     *
     * @return boolean
     */
    public function checkHealth()
    {
        return 200 === $this->getHttpClient()->get(
            $this->getUrl()
        )->getStatusCode();
    }

    /**
     * Retrieves content from the response of a request.
     *
     * @param  \GuzzleHttp\Psr7\Response $response
     * @return string
     */
    public function respond($response)
    {
        $this->setLastResponse($response);

        $response = json_decode(
            $response->getBody()->getContents(), true
        ) ?? (string) $response->getBody();

        return data_get($response, 'data', $response);
    }
}
