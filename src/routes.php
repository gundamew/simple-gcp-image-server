<?php

// Routes

use google\appengine\api\cloud_storage\CloudStorageTools;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Controllers\UploadController;

$app->post('/upload/{bucket:\w+}', UploadController::class . ':save');
