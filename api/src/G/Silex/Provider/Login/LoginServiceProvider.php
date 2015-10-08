<?php

namespace G\Silex\Provider\Login;

use Silex\Application;
use Silex\ServiceProviderInterface;

class LoginServiceProvider implements ServiceProviderInterface {
    const AUTH_VALIDATE_CREDENTIALS = 'auth.validate.credentials';
    const AUTH_VALIDATE_TOKEN       = 'auth.validate.token';
    const AUTH_NEW_TOKEN            = 'auth.new.token';

    private $application;

    public function register(Application $app) {
        $this->application = $app;

        $app[self::AUTH_VALIDATE_CREDENTIALS] = $app->protect(function ($user, $pass) {
            return $this->validateCredentials($user, $pass);
        });

        $app[self::AUTH_VALIDATE_TOKEN] = $app->protect(function ($token) {
            return $this->validateToken($token);
        });

        $app[self::AUTH_NEW_TOKEN] = $app->protect(function ($user) {
            return $this->getNewTokenForUser($user);
        });
    }

    public function boot(Application $app) { }

    private function validateCredentials($user, $pass) {
        $user = $this->application['user.manager']->findOneBy(array('email' => $user));
        $passIsCorrect = $user
            ? $this->application['user.manager']->checkUserPassword($user, $pass)
            : false;

        return $passIsCorrect;
    }

    private function validateToken($token) {
        return $token == 'a';
    }

    private function getNewTokenForUser($user) {
        return 'a';
    }
}
