<?php

/* DEBUG */
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'On');

include __DIR__ . '/../vendor/autoload.php';

use G\Silex\Application;
use Silex\Provider;

$app = new Application();

/* DEBUG */
$app['debug'] = true;

$app->register(
	new Silex\Provider\DoctrineServiceProvider(),
	array(
		'db.options' => array(
            'host'     => 'localhost',
            'user'     => 'root',
            'password' => 'root',
            'dbname'   => 'tinysecrets-test-user',
        ),
		'db.dbal.class_path'   => __DIR__.'/core/vendor/doctrine/dbal/lib',
		'db.common.class_path' => __DIR__.'/core/vendor/doctrine/common/lib',
	)
);

// Security
$app->register(new Provider\SecurityServiceProvider());

$simpleUserProvider = new SimpleUser\UserServiceProvider();
$app->register($simpleUserProvider);

$app['security.firewalls'] = array(
	'secured_area' => array(
		'anonymous' => true,
		'users' => $app->share(function($app) { return $app['user.manager']; }),
	),
);

$app->get('/api/info', function (Application $app) {
    return $app->json([
        'status' => true,
        'info'   => [
            'name'    => 'Gonzalo',
            'surname' => 'Ayuso'
        ]
    ]);
});

$app->run();
