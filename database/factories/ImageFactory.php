<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{

    public function definition(): array
    {

        $images = [
            '643cc0f7444c49.35095125.jpg',
            '643e7961930e43.23654466.jpg',
            '643e79d1251341.06756422.jpg',
            '643e7a31175086.46257612.jpg',
            '643de370e2b662.67452472.jpg',
            '643de0a0cee1f0.89140087.jpg',
            '643ddfa747fa64.79484647.jpg',
            '643ddee93e0ad3.80537891.jpg',
            '643de06352b490.84974403.jpg',
            '643de5960b2180.54903129.jpg',
            '643de503213c83.75622001.jpg',
            '643de5960b2180.54903129.jpg',
            '643de747331934.67931382.jpg',
            '643cc263260731.32100920.jpg',
            '643ddee93e0ad3.80537891.jpg',
        ];

        return [
            'imageable_id'=>fake()->numberBetween(1,10),
            'imageable_type'=>'App\Models\Album',
            'name'=>fake()->name(),
            'upload_name'=>fake()->randomElement($images)
        ];
    }
}
