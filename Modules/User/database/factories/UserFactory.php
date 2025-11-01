<?php

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\Models\User;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nickname' => $this->faker->name(),
            'username' => $this->faker->unique()->userName(),
            'phone'    => $this->faker->unique()->phoneNumber(),
            'email'    => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'), // 默认密码
            'sex'      => 'man',
            'avatar'   => $this->faker->imageUrl(),
            'birthday' => $this->faker->date(),
            'vip'      => 0,
            'status'   => 'normal',
        ];
    }
}
