<?php

use \Phinx\Migration\AbstractMigration;

class ImagesMigration extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('images', [
            'id' => false,
            'primary_key' => 'id',
            'comment' => 'Information of images',
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_unicode_ci',
        ]);

        $table->addColumn('id', 'biginteger', ['limit' => 20, 'signed' => false, 'identity' => true, 'comment' => 'Primary key']);
        $table->addColumn('name', 'string', ['limit' => 255, 'comment' => 'Original image file name']);
        $table->addColumn('bucket', 'string', ['limit' => 255, 'comment' => 'The bucket name which image file stored at']);
        $table->addColumn('object_name', 'string', ['limit' => 255, 'comment' => 'SHA1 value of image file']);
        $table->addColumn('public_link', 'string', ['limit' => 255, 'comment' => 'Public link to image file stored at Cloud Storage']);
        $table->addColumn('serving_url', 'string', ['limit' => 255, 'comment' => 'The image URL returned by Cloud Storage Tools API']);
        $table->addColumn('upload_time', 'datetime', ['comment' => 'Upload time']);

        $table->save();
    }
}
