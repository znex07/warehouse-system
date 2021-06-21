<?php

namespace Database\Factories;

use App\Models\Cargo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CargoFactory extends Factory
{

    protected $model = Cargo::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'cargo_code'  => $this->faker->name,
            'cargo_status'  => $this->faker->name,
            'cargo_description'  => $this->faker->name,
            'official_address'  => $this->faker->name,
            'contact_person' => $this->faker->name
        ];
    }
}
