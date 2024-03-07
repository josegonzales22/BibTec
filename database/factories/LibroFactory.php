<?php

namespace Database\Factories;
use App\Models\Libro;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Libro>
 */
class LibroFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Libro::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'titulo' => $this->faker->sentence,
            'editorial' => $this->faker->company,
            'pub' => $this->faker->year,
            'genero' => $this->faker->word,
            'numpag' => $this->faker->numberBetween(50, 10000),
            'idioma' => $this->faker->languageCode,
            'cantidad' => $this->faker->numberBetween(1, 10000),
        ];
    }
}
