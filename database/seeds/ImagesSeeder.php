<?php

use Phinx\Seed\AbstractSeed;

class ImagesSeeder extends AbstractSeed
{
    public function run()
    {
        $faker = Faker\Factory::create('zh_TW');
        $data = [];

        for ($number = 0; $number < 3; ++$number) {
            $data[] = [
                'name' => $faker->image('/tmp', 640, 480, 'abstract', false),
                'object_name' => $faker->sha1,
                'serving_url' => $faker->imageUrl(),
                'upload_time' => $faker->dateTimeBetween('-1 month', 'now', 'Asia/Taipei')->format('Y-m-d H:i:s'),
            ];
        }

        $posts = $this->table('images');
        $posts->insert($data)->save();
    }
}
