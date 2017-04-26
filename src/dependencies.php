<?php

// DIC configuration

$container = $app->getContainer();

// PDO
$container['database'] = function ($container) {
    $settings = $container->get('settings')['database'];
    $dsn = str_replace(
        ['{SOCKET}', '{NAME}', '{CHARSET}'],
        [$settings['socket'], $settings['name'], $settings['charset']],
        'mysql:unix_socket={SOCKET};dbname={NAME};charset={CHARSET}'
    );
    $options = [
        PDO::ATTR_CASE => PDO::CASE_NATURAL,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL,
        PDO::ATTR_STRINGIFY_FETCHES => false,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    return (new \PDO($dsn, $settings['user'], $settings['password'], $options));
};

// default error handler
$container['errorHandler'] = function () {
    return function ($request, $response, $exception) {
        return $response->withJson(
            ['message' => $exception->getMessage()],
            $response->getStatusCode(),
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    };
};

// HTTP 404 "Not Found" error handler
$container['notFoundHandler'] = function () {
    return function ($request, $response) {
        return $response->withStatus(404)->withJson(['message' => 'Page not found']);
    };
};

// HTTP 405 "Not Allowed" error handler
$container['notAllowedHandler'] = function () {
    return function ($request, $response, $methods) {
        return $response->withStatus(405)->withHeader('Allow', implode(', ', $methods))->withJson(['message' => 'Method not allowed']);
    };
};

// Available buckets
$container['availableBuckets'] = function () {
    return $container->get('settings')['availableBuckets'];
};
