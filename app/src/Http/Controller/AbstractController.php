<?php

namespace Mock\Api\Http\Controller;

use Pop\Application;
use Pop\Http\Request;
use Pop\Http\Response;

abstract class AbstractController extends \Pop\Controller\AbstractController
{

    /**
     * Application object
     * @var Application
     */
    protected $application = null;

    /**
     * Request object
     * @var Request
     */
    protected $request = null;

    /**
     * Response object
     * @var Response
     */
    protected $response = null;

    /**
     * Constructor for the controller
     *
     * @param  Application $application
     * @param  Request     $request
     * @param  Response    $response
     */
    public function __construct(Application $application, Request $request, Response $response)
    {
        $this->application = $application;
        $this->request     = $request;
        $this->response    = $response;
    }

    /**
     * Get application object
     *
     * @return Application
     */
    public function application()
    {
        return $this->application;
    }

    /**
     * Get request object
     *
     * @return Request
     */
    public function request()
    {
        return $this->request;
    }

    /**
     * Get response object
     *
     * @return Response
     */
    public function response()
    {
        return $this->response;
    }

    /**
     * Send method
     *
     * @param  string $body
     * @param  int    $code
     * @param  string $message
     * @param  array  $headers
     * @return void
     */
    public function send($body = null, $code = 200, $message = null, array $headers = null)
    {
        if (null !== $message) {
            $this->response->setMessage($message);
        }

        if (null !== $headers) {
            $headers = array_merge($this->application->config['http_options_headers'], $headers);
        } else {
            $headers = $this->application->config['http_options_headers'];
        }
        $this->response->setHeaders($headers);

        $responseBody = (!empty($body)) ? json_encode($body, JSON_PRETTY_PRINT) : $body;

        $this->response->setCode($code);
        $this->response->setBody($responseBody . PHP_EOL . PHP_EOL);
        $this->response->send();
    }

    /**
     * Send OPTIONS response
     *
     * @param  int    $code
     * @param  string $message
     * @param  array  $headers
     * @return void
     */
    public function sendOptions($code = 200, $message = null, array $headers = null)
    {
        $this->send('', $code, $message, $headers);
    }

}