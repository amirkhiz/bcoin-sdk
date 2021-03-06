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
use Habil\Bcoin\Meta\Helper;
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
        $this->validate(
            [
                'username' => $username,
                'password' => $password,
                'ip'       => $ip,
                'port'     => $port,
            ]
        );

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

    /**
     * @param $data
     *
     * @throws \Habil\Bcoin\Exceptions\BcoinException
     */
    private function validate($data)
    {
        $validator = new Validator;
        $validator->add(
            [
                'username' => 'required',
                'password' => 'required',
                'ip'       => 'required',
                'port'     => 'required | integer',
            ]
        );

        if (!$validator->validate($data)) {
            foreach ($validator->getMessages() as $rule => $message) {
                foreach ($message as $item) {
                    throw new BcoinException($item, 5001);
                }
            }
        }
    }
}