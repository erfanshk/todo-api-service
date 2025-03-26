<?php

namespace App\Domains\Todo\Database\Factories;


use App\Domains\Todo\Database\Models\Todo;
use App\Domains\Todo\Enums\TodoStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class TodoFactory extends Factory
{
    protected $model = Todo::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->title,
            'description' => $this->faker->text,
        ];
    }

    public function pending(): static
    {
        return $this->state(fn(array $attributes) => ['status' => TodoStatusEnum::PENDING]);
    }
    public function inProgress(): static
    {
        return $this->state(fn(array $attributes) => ['status' => TodoStatusEnum::IN_PROGRESS]);
    }
    public function done(): static
    {
        return $this->state(fn(array $attributes) => ['status' => TodoStatusEnum::DONE,'done_at'=>now()]);
    }
}
