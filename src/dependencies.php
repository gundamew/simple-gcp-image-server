<?php

// DIC configuration

$container = $app->getContainer();

// monolog
$container['logger'] = function ($container) {
    $settings = $container->get('settings')['logger'];
    Monolog\Logger::setTimezone(new \DateTimeZone($settings['timezone']));
    $formatter = new Monolog\Formatter\LineFormatter;
    $formatter->ignoreEmptyContextAndExtra();
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushHandler((new Monolog\Handler\StreamHandler($settings['path'], $settings['level']))->setFormatter($formatter));
    return $logger;
};

// PDO
$container['database'] = function ($container) {
    $settings = $container->get('settings')['database'];
    $dsn = str_replace(
        ['{HOST}', '{NAME}', '{CHARSET}'],
        [$settings['host'], $settings['name'], $settings['charset']],
        'mysql:host={HOST};dbname={NAME};charset={CHARSET}'
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
$container['errorHandler'] = function ($container) {
    return function ($request, $response, $exception) use ($container) {
        $container->logger->error($exception->getMessage());
        return $response->withJson(
            ['message' => $exception->getMessage()],
            $response->getStatusCode(),
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    };
};

// HTTP 404 "Not Found" error handler
$container['notFoundHandler'] = function ($container) {
    return function ($request, $response) use ($container) {
        return $response->withStatus(404)->withJson(['message' => 'Page not found']);
    };
};

// HTTP 405 "Not Allowed" error handler
$container['notAllowedHandler'] = function ($container) {
    return function ($request, $response, $methods) use ($container) {
        return $response->withStatus(405)->withHeader('Allow', implode(', ', $methods))->withJson(['message' => 'Method not allowed']);
    };
};
