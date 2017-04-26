<?php

namespace Controllers;

use google\appengine\api\cloud_storage\CloudStorageTools;
use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;

class UploadController
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function save(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $files = $request->getUploadedFiles();

        if (!isset($files['upload-image'])) {
            throw new \Exception(sprintf('%s at line %d: No file uploaded or invalid form name', static::class, __LINE__));
        }

        $bucketName = $this->container['availableBuckets'][$args['bucket']];

        $savedFileInfo = $this->saveImage($files['upload-image'], $bucketName);

        $sql = <<<SQL
INSERT INTO images (
    name, object_name, public_link, serving_url, upload_time
) VALUES (
    :name, :object_name, :public_link, :serving_url, :upload_time
)
SQL;

        $uploadTime = (new \DateTime('now', new \DateTimeZone('Asia/Taipei')))->format('Y-m-d H:i:s');

        $query = $this->container->database->prepare($sql);
        $query->bindParam(':name', $savedFileInfo['name'], \PDO::PARAM_STR);
        $query->bindParam(':object_name', $savedFileInfo['objectName'], \PDO::PARAM_STR);
        $query->bindParam(':public_link', $savedFileInfo['publicLink'], \PDO::PARAM_STR);
        $query->bindParam(':serving_url', $savedFileInfo['servingUrl'], \PDO::PARAM_STR);
        $query->bindParam(':upload_time', $uploadTime, \PDO::PARAM_STR);
        $isSaved = $query->execute();

        if (!$isSaved) {
            throw new \Exception(sprintf('%s at line %d: Failed to write to database', static::class, __LINE__));
        }

        return $response->withStatus(200)->withJson([
            'public_link' => $savedFileInfo['publicLink'],
            'serving_url' => $savedFileInfo['servingUrl'],
        ]);
    }

    private function saveImage(UploadedFileInterface $newFile, $bucketName = '')
    {
        if ($bucketName === '') {
            $bucketName = CloudStorageTools::getDefaultGoogleStorageBucketName();
        }

        $objectName = sha1(file_get_contents($newFile->file));

        $gsFile = 'gs://' . $bucketName . '/' . $objectName;

        $newFile->moveTo($gsFile);

        return [
            'name' => $newFile->getClientFilename(),
            'objectName' => $objectName,
            'publicLink' => 'https://storage.googleapis.com/' . $bucketName . '/' . $objectName,
            'servingUrl' => CloudStorageTools::getImageServingUrl($gsFile, ['secure_url' => true]),
        ];
    }
}
