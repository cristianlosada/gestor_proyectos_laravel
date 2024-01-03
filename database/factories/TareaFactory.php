<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\tarea>
 */
class TareaFactory extends Factory
{
    /**
     * Define el valor por defecto de la tabla tareas
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'proyecto_id'  => $this->faker->numberBetween(1, 15),
            'titulo'       => substr($this->faker->sentence(), 0, 29),
            'descripcion'  => $this->faker->sentence(),
            'estado_tarea' => $this->faker->numberBetween(1, 3),
            'estado'       => $this->faker->numberBetween(0, 1)
        ];
    }
}
