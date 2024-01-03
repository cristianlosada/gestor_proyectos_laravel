<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proyecto>
 */
class ProyectoFactory extends Factory
{
    /**
     * Define el valor por defecto de la tabla proyectos
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo'       => substr($this->faker->sentence(), 0, 29),
            'descripcion'  => $this->faker->sentence(),
            'fecha_inicio' => now(),
            'fecha_final'  => now()->addMonth(),
            'estado'       => $this->faker->numberBetween(0, 1)
        ];
    }
}
