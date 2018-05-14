<?php

namespace App;

use Psr\Http\Message\UploadedFileInterface;

abstract class AbstractGsFileHandler
{
    protected $uploadedFile;

    public function __construct(UploadedFileInterface $uploadedFile)
    {
        $this->uploadedFile = $uploadedFile;
    }

    public function getFilename()
    {
        return $this->uploadedFile->getClientFilename();
    }

    public function getFilePath()
    {
        return $this->uploadedFile->file;
    }

    public function moveTo($gsFilename)
    {
        return $this->uploadedFile->moveTo($gsFilename);
    }

    public function save(\PDO $db, array $info)
    {
        $sql = <<<SQL
INSERT INTO images (
    name, bucket_name, object_name, public_url, serving_url, upload_time
) VALUES (
    :name, :bucket_name, :object_name, :public_url, :serving_url, :upload_time
)
SQL;

        $query = $db->prepare($sql);
        $query->bindParam(':name', $info['name'], \PDO::PARAM_STR);
        $query->bindParam(':bucket_name', $info['bucketName'], \PDO::PARAM_STR);
        $query->bindParam(':object_name', $info['objectName'], \PDO::PARAM_STR);
        $query->bindParam(':public_url', $info['publicUrl'], \PDO::PARAM_STR);
        $query->bindParam(':serving_url', $info['servingUrl'], \PDO::PARAM_STR);
        $query->bindParam(':upload_time', (new \DateTime('now', new \DateTimeZone('Asia/Taipei')))->format(\DateTime::ATOM), \PDO::PARAM_STR);

        $isSaved = $query->execute();

        if (!$isSaved) {
            throw new \Exception('Failed to write to database');
        }

        return true;
    }

    abstract public function getDefaultBucketName();

    abstract public function getObjectName($filePath);

    abstract public function getGsFilename($bucketName, $objectName);

    abstract public function getImageServingUrl($gsFilename, array $options);

    abstract public function getPublicUrl($gsFilename, $useHttps);
}
