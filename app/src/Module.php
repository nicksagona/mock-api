<?php

namespace Mock\Api;

use Pop\Application;
use Pop\Db\Db;
use Pop\Db\Record;
use Pop\Http\Request;
use Pop\Http\Response;

class Module extends \Pop\Module\Module
{

    /**
     * Module name
     * @var string
     */
    protected $name = 'mock-api';

    /**
     * Register module
     *
     * @param  Application $application
     * @return Module
     */
    public function register(Application $application)
    {
        parent::register($application);

        if (isset($this->application->config['database'])) {
            $this->initDb($this->application->config['database']);
        }

        if (null !== $this->application->router()) {
            $this->application->router()->addControllerParams(
                '*', [
                    'application' => $this->application,
                    'request'     => new Request(),
                    'response'    => new Response()
                ]
            );
        }

        if ($this->application->config['auth']) {
            $this->application->on('app.dispatch.pre', 'Mock\Api\Http\Event\Auth::authenticate', 1);
        }
        $this->application->on('app.dispatch.pre', 'Mock\Api\Http\Event\Options::check', 2);

        return $this;
    }

    /**
     * HTTP error handler method
     *
     * @param  \Exception $exception
     * @return void
     */
    public function httpError(\Exception $exception)
    {
        $response = new Response();
        $message  = $exception->getMessage();

        $response->setHeader('Content-Type', 'application/json');
        $response->setBody(json_encode(['error' => $message], JSON_PRETTY_PRINT) . PHP_EOL);

        $response->send(500);
        exit();
    }

    /**
     * Initialize database service
     *
     * @param  array $database
     * @throws \Pop\Db\Adapter\Exception
     * @return void
     */
    protected function initDb($database)
    {
        if (!empty($database['adapter'])) {
            $adapter = $database['adapter'];
            $options = [
                'database' => $database['database'],
                'username' => $database['username'],
                'password' => $database['password'],
                'host'     => $database['host'],
                'type'     => $database['type']
            ];

            $check = Db::check($adapter, $options);

            if (null !== $check) {
                throw new \Pop\Db\Adapter\Exception('Error: ' . $check);
            }

            $this->application->services()->set('database', [
                'call'   => 'Pop\Db\Db::connect',
                'params' => [
                    'adapter' => $adapter,
                    'options' => $options
                ]
            ]);

            if ($this->application->services()->isAvailable('database')) {
                Record::setDb($this->application->services['database']);
            }
        }
    }

}