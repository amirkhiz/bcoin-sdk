<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 22.01.2018
 * Time: 16:12
 */

namespace Habil\Bcoin;

use GuzzleHttp\Client;

class Connection
{
    /**
     * The Wallet password
     *
     * @var string
     */
    protected $username;

    /**
     * The Wallet password
     *
     * @var string
     */
    protected $password;

    /**
     * The Full node server ip address
     *
     * @var string
     */
    protected $ip;

    /**
     * The Full node server Port
     *
     * @var string
     */
    protected $port;

    /**
     * The HTTP Client
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    public function __construct($username, $password, $ip, $port)
    {
        $this->username = $username;
        $this->password = $password;
        $this->ip       = $ip;
        $this->port     = $port;
    }

    /**
     * Return an HTTP client instance
     *
     * @return \GuzzleHttp\Client
     */
    public function client()
    {
        if ($this->client) return $this->client;

        return new Client(
            [
                'base_url' => "http://{$this->username}:{$this->password}@{$this->ip}:{$this->port}",
                'defaults' => [
                    'headers' => [
                        'Accept'       => 'application/json',
                        'Content-Type' => 'application/json',
                    ],
                ],
            ]
        );
    }

    /**
     * Send a GET request
     * @param string $uri
     * @param array  $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function get($uri, array $params = [])
    {
        $options = [];
        !empty($params) && $options['query'] = $params;

        return $this->client()->get(
            $uri,
            $options
        );
    }

    /**
     * Send a POST request
     *
     * @param string $uri
     * @param string $body
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function post($uri, $body)
    {
        $options = [];
        !empty($body) && $options['body'] = $body;

        return $this->client()->post(
            $uri,
            $options
        );
    }

    /**
     * Send a PUT request
     *
     * @param string $uri
     * @param string $body
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function put($uri, $body)
    {
        $options = [];
        !empty($body) && $options['body'] = $body;

        return $this->client()->put(
            $uri,
            $options
        );
    }
}