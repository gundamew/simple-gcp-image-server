<?php

// Routes

use App\GsFileHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

$app->post('/upload', function (ServerRequestInterface $request, ResponseInterface $response) {
    $files = $request->getUploadedFiles();

    if (!isset($files['upload-image'])) {
        throw new \Exception('No file uploaded or invalid form name');
    }

    $handler = new GsFileHandler($files['upload-image']);

    $bucket = $handler->getDefaultBucketName();
    $object = $handler->getObjectName($handler->getFilePath());
    $gsFilename = $handler->getGsFilename($bucket, $object);

    $handler->moveTo($gsFilename);

    $info = [
        'name' => $handler->getFilename(),
        'bucketName' => $bucket,
        'objectName' => $object,
        'publicUrl' => $handler->getPublicUrl($gsFilename),
        'servingUrl' => $handler->getImageServingUrl($gsFilename, []),
    ];

    $handler->save($this->database, $info);

    return $response->withStatus(200)->withJson([
        'public_url' => $info['publicUrl'],
        'serving_url' => $info['servingUrl'],
    ]);
});
