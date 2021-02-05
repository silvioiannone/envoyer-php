<?php

namespace SilvioIannone\EnvoyerPhp;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface;
use SilvioIannone\EnvoyerPhp\Exceptions\NotFound;
use SilvioIannone\EnvoyerPhp\Exceptions\Unauthorized;
use SilvioIannone\EnvoyerPhp\Utils\Arr;

/**
 * A base Envoyer resource.
 */
abstract class Resource
{
    /**
     * HTTP client.
     */
    protected Client $client;
    
    /**
     * Resource constructor.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    
    /**
     * Get the base endpoint for the resource.
     */
    protected function getResourceEndpoint(): string
    {
        $name = (new \ReflectionClass($this))->getShortName();
        
        return mb_convert_case($name, MB_CASE_LOWER);
    }
    
    /**
     * Send a GET request.
     */
    protected function sendGet(string $uri = ''): Collection
    {
        $resourceUri = $this->getResourceEndpoint();
    
        if ($uri) {
            $resourceUri .= '/' . $uri;
        }
        
        return collect($this->request('GET', $resourceUri));
    }
    
    /**
     * Send a POST request.
     */
    protected function sendPost(string $uri = '', array $data = []): void
    {
        $resourceUri = $this->getResourceEndpoint();
        
        if ($uri) {
            $resourceUri .= '/' . $uri;
        }
        
        $this->request('POST', $resourceUri, $data);
    }
    
    /**
     * Send an HTTP request.
     */
    protected function request(string $method, string $uri = '', array $data = []): Collection
    {
        $options = [];
        
        if ($method === 'POST') {
            $options = ['json' => $data];
        }
        
        try {
            $response = $this->client->request($method, $uri, $options)
                ->getBody()
                ->getContents();
        } catch (ClientException $exception) {
            $this->handleRequestException($exception);
        }
        
        return Arr::toCollection(json_decode($response, true));
    }
    
    /**
     * Handle the request exception.
     */
    protected function handleRequestException(\Exception $exception): void
    {
        switch ($exception->getCode()) {
            case 401:
                throw new Unauthorized();
            case 404:
                throw new NotFound();
            default:
                throw $exception;
        }
    }
}
