<?php

namespace Database\Factories;

use App\Models\post;
use Illuminate\Database\Eloquent\Factories\Factory;

class postFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'post_caption' => $this->faker->paragraph,
            'image_path' => 'uploads/' . $this->faker->image('public/storage/uploads', 800, 600, null, false)
        ];
    }
}
