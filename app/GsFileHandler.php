<?php

namespace App;

use google\appengine\api\cloud_storage\CloudStorageTools;

class GsFileHandler extends AbstractGsFileHandler
{
    public function getDefaultBucketName()
    {
        return CloudStorageTools::getDefaultGoogleStorageBucketName();
    }

    public function getObjectName($filePath)
    {
        return sha1(file_get_contents($filePath));
    }

    public function getGsFilename($bucketName, $objectName)
    {
        return CloudStorageTools::getFilename($bucketName, $objectName);
    }

    public function getImageServingUrl($gsFilename, $options = [])
    {
        if (!array_key_exists('secure_url', $options)) {
            $options = array_merge($options, ['secure_url' => true]);
        }

        return CloudStorageTools::getImageServingUrl($gsFilename, $options);
    }

    public function getPublicUrl($gsFilename, $useHttps = true)
    {
        return CloudStorageTools::getPublicUrl($gsFilename, $useHttps);
    }
}
