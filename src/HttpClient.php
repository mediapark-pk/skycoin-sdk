<?php
declare(strict_types=1);

namespace SkyCoin;

use Comely\Http\Request;
use SkyCoin\Exception\SkyCoinAPIException;

/**
 * Class HttpClient
 * @package SkyCoin
 */
class HttpClient
{
    /** @var string */
    private string $ip;
    /** @var int|null */
    private ?int $port;
    /** @var string|null */
    private ?string $username;
    /** @var string|null */
    private ?string $password;
    /** @var bool */
    private bool $https;

    /**
     * HttpClient constructor.
     * @param string $ip
     * @param int|null $port
     * @param string|null $username
     * @param string|null $password
     * @param bool $https
     */
    public function __construct(string $ip, ?int $port = null, ?string $username = "", ?string $password = "", bool $https = false)
    {
        $this->ip = $ip;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->https = $https;
    }

    /**
     * @return string
     * @throws SkyCoinAPIException
     * @throws \Comely\Http\Exception\HttpException
     */
    public function getCSRFToken(): string
    {
        $csrfToken = $this->sendRequest("/v1/csrf")["csrf_token"] ?? null;
        if (!is_string($csrfToken) || !$csrfToken) {
            throw new SkyCoinAPIException('Could not retrieve CSRF token');
        }

        return $csrfToken;
    }

    /**
     * @param string $endpoint
     * @param array $params
     * @param array $headers
     * @param string $httpMethod
     * @return array
     * @throws SkyCoinAPIException
     * @throws \Comely\Http\Exception\HttpException
     */
    public function sendRequest(string $endpoint, array $params = [], array $headers = [], string $httpMethod = "GET"): array
    {
        $url = $this->generateUri($endpoint);
        $req = new Request($httpMethod, $url);

        // Set CSRF header if request is not GET
        if (strtoupper($httpMethod) != "GET") {
            $req->headers()->set("X-CSRF-Token", $this->getCSRFToken());
        }

        // Set Request Headers
        $req->headers()->set("accept", "application/json");

        // Set Dynamic Headers
        if ($headers) {
            foreach ($headers as $key => $value) {
                $req->headers()->set($key, $value);
            }
        } else {
            $req->headers()->set("content-type", "application/json");
        }

        // Set Request Body/Params
        if ($params) {
            $req->payload()->use($params);
        }

        $request = $req->curl();
        if ($this->username && $this->password) {
            $request->auth()->basic($this->username, $this->password);
        }

        // Send The Request
        $res = $request->send();
        $errCode = $res->code();
        if ($errCode !== 200) {
            $errMsg = $res->body()->value();
            if ($errMsg) {
                $errMsg = trim(strval(explode("-", $errMsg)[1] ?? ""));
                throw new SkyCoinAPIException($errMsg ? $errMsg : sprintf('HTTP Response Code %d', $errCode), $errCode);
            }
        }

        return $res->payload()->array();
    }

    /**
     * @param string|null $endpoint
     * @return string
     */
    public function generateUri(?string $endpoint = null): string
    {
        $url = sprintf('%s://%s', $this->https ? "https" : "http", $this->ip);
        if ($this->port) {
            $url .= ":" . $this->port;
        }

        if ($endpoint) {
            $url .= "/api/" . ltrim($endpoint, "/");
        }

        return $url;
    }
}
