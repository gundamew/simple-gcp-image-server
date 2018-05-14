<?php

use \Faker\Factory as FakerFactory;
use \Phinx\Seed\AbstractSeed;

class ImagesSeeder extends AbstractSeed
{
    public function run()
    {
        $faker = FakerFactory::create('zh_TW');
        $data = [];

        for ($number = 1; $number <= 10; ++$number) {
            $bucketName = $faker->domainWord();
            $objectName = $faker->sha1();

            $data[] = [
                'name' => $faker->userName(),
                'bucket_name' => $bucketName,
                'object_name' => $objectName,
                'public_URL' => 'https://storage.googleapis.com/' . $bucketName . '/' . $objectName,
                'serving_url' => 'https://lh3.googleusercontent.com/' . base64_encode($faker->sha256()),
                'upload_time' => $faker->dateTimeThisMonth('now', 'Asia/Taipei')->format('Y-m-d H:i:s'),
            ];
        }

        $this->table('images')->insert($data)->save();
    }
}
