<?php

namespace SilvioIannone\EnvoyerPhp;

use GuzzleHttp\Client as HttpClient;
use Laminas\Uri\Http;
use SilvioIannone\EnvoyerPhp\Resources\Deployments;
use SilvioIannone\EnvoyerPhp\Resources\Projects;

/**
 * Laravel Envoyer client.
 */
class Client
{
    /**
     * API base URI.
     */
    protected const BASE_URI = 'https://envoyer.io/api';
    
    /**
     * HTTP client.
     */
    protected HttpClient $http;
    
    /**
     * Client constructor.
     */
    public function __construct(string $token)
    {
        $this->http = (new HttpClient([
            'base_uri' => static::BASE_URI . '/',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ]
        ]));
    }
    
    /**
     * Access the projects resource.
     */
    public function projects(): Projects
    {
        return $this->makeResource('projects');
    }
    
    /**
     * Make a resource.
     */
    protected function makeResource(string $resource): Resource
    {
        $class = __NAMESPACE__ . '\\Resources\\' . mb_convert_case($resource, MB_CASE_TITLE);
        
        return new $class($this->http);
    }
}
