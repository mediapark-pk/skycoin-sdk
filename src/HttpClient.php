<?php

namespace SkyCoin;


use SkyCoin\API\Generic;
use SkyCoin\Exception\SkyCoinException;
use Comely\Http\Request;

class HttpClient
{

    /** @var string */
    private string $ip;
    /** @var int */
    private ?int $port = NULL;
    /** @var string */
    private string $username;
    /** @var string */
    private string $password;

    /**
     * HttpClient constructor.
     * @param string $ip
     * @param int|null $port
     * @param string|null $username
     * @param string|null $password
     */
    public function __construct(string $ip, ?int $port = NULL, ?string $username = "", ?string $password = "")
    {
        $this->ip = $ip;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
    }


    /**
     * @param string $uri
     * @param array $params
     * @param string|string $httpMethod
     * @return \Exception|Exception
     * @throws SkyCoinException
     */
    public function sendRequest(string $uri, array $params = [], array $headers = [], string $httpMethod = "POST")
    {
        $url = null;
        //If port is given or not
        if ($this->port) {
            try {
                $url = self::generateUrl($this->ip, $this->port);
            } catch (Exception $e) {
                return $e;

            }
        } else {

            $url = $this->ip;
        }

        //Set Complete Url
        $url .= $uri;
//        print_r($url);
//        die();
        //Create Request Instance
        $request = new Request($httpMethod, $url);

        //Set CSRF header if request is not GET
        if (strtoupper($httpMethod) != "GET") {
            $generic = new Generic($this);
            $csrf = $generic
                ->csrfToken()
                ->payload()
                ->get("csrf_token");

            $request
                ->headers()
                ->set("X-CSRF-Token", $csrf);
        }

//        print_r($params);die();
        //HardCode For Testing Purpose
//        $request
//            ->headers()
//            ->set("X-CSRF-Token", "eyJOb25jZSI6IkRYUlBWeVN3S2J3d1lLekZyVlR3UmJWenpWSnFKWDVSMDE4ajRKaFNOQnVEOVphYkFsTUlBU3R4UWQvWnR5dGI1S1JoWDZwYkVWZDFrVGhBenUxbHNnPT0iLCJFeHBpcmVzQXQiOiIyMDIwLTA5LTA5VDA2OjExOjIzLjQ0OTQ3NDU5NFoifQ._Mxd_UEOun171fwEsMyo9_tRqsKvLwDkms_226W86I4");

        //Set Request Headers
        $request
            ->headers()
            ->set("Accept", "application/json");

        //Set Dynamic Headers
        if (count($headers) > 0) {

            array_walk($headers, ['self', "setHeaders"], $request);
        } else {
            $request
                ->headers()
                ->set("Content-Type", "application/json");
        }
        //Set Request Body/Params

        $params ? $request->payload()->use($params) : null;

        $request = $request->curl();


        //Set Basic Authentication
//        $request->auth()->basic($this->username, $this->password);


        //Send The Request
        $response = $request->send();



        $errorCode = $response->code();
        if ($errorCode != 200) {

            if ($errorCode == 400) {
                $errorMessage = $error["message"] ?? 'Bad Request';
            } elseif ($errorCode == 401) {
                $errorMessage = $error["message"] ?? 'Unauthorized';
            } elseif ($errorCode == 403) {
                $errorMessage = $error["message"] ?? 'Forbidden';
            } else if ($errorCode == 404) {
                $errorMessage = $error["message"] ?? 'Not Found';
            } else {
                $errorMessage = $error["message"] ?? 'An error occurred';
            }

            throw new SkyCoinException($errorMessage, $errorCode);
        }

        // Check for Error
        $error = $response->payload()->get("error");
        if (is_array($error)) {

            $errorCode = intval($error["code"] ?? 0);


            $errorMessage = $error["message"] ?? 'An error occurred';

            throw new SkyCoinException($errorMessage, $errorCode);
        }
        // Result
        if (($response->payload()->get("result") != 0) && (!$response->payload()->get("result"))) {
            throw new SkyCoinException('No response was received');
        }

        return $response;

    }


    /**
     * @param string $ip
     * @param int $port
     * @return string
     */
    public function generateUrl(string $ip, int $port): string
    {
        /*Port Checking */
        if (!is_numeric($port)) {
            throw new Exception("A port can only be a number", 1);

        }
        return $ip . ":" . $port;
    }


    /**
     * @param string $uri
     * @param array $replaceBy
     * @param array $find
     * @return string
     */
    public function generateURI(string $uri, array $replaceBy, array $find): string
    {
        $result = str_replace(
            $find,
            $replaceBy,
            $uri
        );
        return $result;

    }


    /**
     * @param $value
     * @param $key
     * @param $request
     */
    public function setHeaders($value, $key, &$request)
    {
        $request
            ->headers()
            ->set($key, $value);
    }


}