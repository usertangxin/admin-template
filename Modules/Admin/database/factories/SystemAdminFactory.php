<?php

namespace Modules\Admin\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SystemAdminFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Admin\Models\SystemAdmin::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'admin_name' => $this->faker->unique()->userName,
            'password'   => 123456,
            'nickname'   => $this->faker->name,
        ];
    }
}
