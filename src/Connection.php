<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 22.01.2018
 * Time: 16:12
 */

namespace Habil\Bcoin;

use GuzzleHttp\Client;
use Habil\Bcoin\Exceptions\BcoinException;
use Sirius\Validation\Validator;

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

    /**
     * Connection constructor.
     *
     * @param $username
     * @param $password
     * @param $ip
     * @param $port
     *
     * @throws \Habil\Bcoin\Exceptions\BcoinException
     */
    public function __construct($username, $password, $ip, $port)
    {
        $validator = new Validator;
        $validator->add(
            [
                'username' => 'required',
                'password' => 'required',
                'ip'       => 'required|ip',
                'port'     => 'required|integer',
            ]
        );

        $data = [
            'username' => $username,
            'password' => $password,
            'ip'       => $ip,
            'port'     => $port,
        ];

        if (!$validator->validate($data)) {
            throw new BcoinException(join('- ', $validator->getMessages()), 5001);
        }

        $this->username = $username;
        $this->password = $password;
        $this->ip       = $ip;
        $this->port     = $port;
    }

    /**
     * Return an HTTP client instance
     *
     * @return \GuzzleHttp\Client
     * @throws \Habil\Bcoin\Exceptions\BcoinException
     */
    public function client()
    {
        if ($this->client) return $this->client;

        try {
            return new Client(
                [
                    'base_uri' => "http://{$this->username}:{$this->password}@{$this->ip}:{$this->port}",
                ]
            );
        } catch (\Exception $e) {
            throw new BcoinException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Send a GET request
     *
     * @param string $uri
     * @param array  $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Habil\Bcoin\Exceptions\BcoinException
     */
    public function get($uri, array $params = [])
    {
        try {
            $options = [];
            !empty($params) && $options['query'] = $params;

            return $this->client()->get(
                $uri,
                $options
            );
        } catch (\Exception $e) {
            throw new BcoinException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Send a POST request
     *
     * @param string $uri
     * @param string $body
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Habil\Bcoin\Exceptions\BcoinException
     */
    public function post($uri, $body)
    {
        try {
            $options = [];
            !empty($body) && $options['body'] = $body;

            $options['header'] = [
                'Content-Type' => 'application/json',
            ];

            return $this->client()->post(
                $uri,
                $options
            );
        } catch (\Exception $e) {
            throw new BcoinException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Send a PUT request
     *
     * @param string $uri
     * @param string $body
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Habil\Bcoin\Exceptions\BcoinException
     */
    public function put($uri, $body)
    {
        try {
            $options = [];
            !empty($body) && $options['body'] = $body;

            $options['header'] = [
                'Content-Type' => 'application/json',
            ];

            return $this->client()->put(
                $uri,
                $options
            );
        } catch (\Exception $e) {
            throw new BcoinException($e->getMessage(), $e->getCode());
        }
    }
}