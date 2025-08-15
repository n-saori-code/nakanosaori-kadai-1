<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // 既存カテゴリのIDを配列で取得
        $categoryIds = Category::pluck('id')->toArray();

        return [
            'last_name'   => $this->faker->lastName(),
            'first_name'  => $this->faker->firstName(),
            'gender'      => $this->faker->numberBetween(1, 3),
            'email'       => $this->faker->unique()->safeEmail(),
            'tel'         => $this->faker->numerify('0##########'),
            'address'     => $this->faker->address(),
            'building'    => $this->faker->optional()->secondaryAddress(),
            'category_id' => $this->faker->randomElement($categoryIds),
            'detail'      => $this->faker->realText(50),
        ];
    }
}
