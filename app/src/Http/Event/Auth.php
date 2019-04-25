<?php
namespace Mock\Api\Http\Event;

use Pop\Application;

class Auth
{

    /**
     * Method to check auth
     *
     * @param  Application $application
     * @return void
     */
    public static function authenticate(Application $application)
    {
        $authHeader = $application->router()->getController()->request()->getHeader('Authorization');
        if (strpos($authHeader, 'Bearer ') !== false) {
            $authHeader = substr($authHeader, 7);
        }
        if ($authHeader != $application->config['auth_key']) {
            $application->router()->getController()->send(401, ['error' => 'Unauthorized']);
            exit();
        }
    }

}