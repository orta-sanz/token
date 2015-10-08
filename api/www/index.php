<?php

/* DEBUG */
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'On');

include __DIR__ . '/../vendor/autoload.php';

use G\Silex\Application;
use Silex\Provider;

$app = new Application();

$app->register(
	new Silex\Provider\DoctrineServiceProvider(),
	array(
		'db.options' => array(
            'host'     => 'localhost',
            'user'     => 'root',
            'password' => 'root',
            'dbname'   => 'test',
        ),
		'db.dbal.class_path'   => __DIR__.'/core/vendor/doctrine/dbal/lib',
		'db.common.class_path' => __DIR__.'/core/vendor/doctrine/common/lib',
	)
);

// USERS AND SECURITY
$app->register(new Provider\SecurityServiceProvider());

$simpleUserProvider = new SimpleUser\UserServiceProvider();
$app->register($simpleUserProvider);

// Firewall temporarily empty
$app['security.firewalls'] = array();

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
