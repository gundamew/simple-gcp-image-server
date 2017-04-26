CREATE TABLE `images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary key',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Original image file name',
  `bucket` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The bucket name which image file stored at',
  `object_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'SHA1 value of image file',
  `public_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Public link to image file stored at Cloud Storage',
  `serving_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The image URL returned by Cloud Storage Tools API',
  `upload_time` datetime NOT NULL COMMENT 'Upload time',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
