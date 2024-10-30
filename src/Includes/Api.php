<?php

namespace LimousineSearch\Includes;

use LimousineSearch\Entities\Company;
use LimousineSearch\Exceptions\NotFoundException;
use LimousineSearch\Exceptions\UnauthorizedException;

class Api
{
    private string $endpoint = 'https://api.limousinesearch.com';
    private ?array $headers = null;

    private ?string $apiToken = null;
    private string $pluginName;

    public function __construct(string $pluginName, string $apiToken = null)
    {
        $this->pluginName = $pluginName;
        $this->apiToken = $apiToken;
    }

    private  function getApiToken(): ?string
    {
        if ($this->apiToken !== null) {
            return $this->apiToken;
        }

        $options = get_option($this->pluginName . '_settings');
        $this->apiToken = $options[$this->pluginName . '_api_token'];

        return $this->apiToken;
    }

    private function getHeader(): array
    {
        if (is_array($this->headers)) {
            return $this->headers;
        }

        $this->headers = [
            'Authorization' => 'Bearer ' . $this->getApiToken(),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        return $this->headers;
    }

    private function post(string $endpoint, array $options = []): array
    {
        $response = wp_remote_post(
            $this->endpoint . '/' . trim($endpoint, '/'),
            array_merge(['headers' => $this->getHeader()], $options)
        );

        return $this->response($endpoint, $response);
    }

    private function get(string $endpoint, array $options = []): array
    {
        $response = wp_remote_get(
            $this->endpoint . '/' . trim($endpoint, '/'),
            array_merge(['headers' => $this->getHeader()], $options)
        );

        return $this->response($endpoint, $response);
    }

    private function response(string $endpoint, $response): array
    {
        $code = wp_remote_retrieve_response_code($response);
        $body = json_decode(wp_remote_retrieve_body($response), true);

        if ($code === 404) {
            throw new NotFoundException('Not Found: ' . $endpoint);
        }

        if ($code === 401) {
            throw new UnauthorizedException();
        }

        if (!str_starts_with((string) $code, '2')) {
            throw new \Exception($body['message'] ?? 'An error has occurred', $code);
        }

        return $body;
    }

    public function try(): array
    {
        return $this->get('try');
    }

	public function company(): Company
    {
        $response = $this->get('company');

        return Company::fromApi($response);
	}
}
