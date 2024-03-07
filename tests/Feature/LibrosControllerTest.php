<?php

namespace Tests\Feature;

use App\Models\Libro;
use App\Models\User;
use Tests\TestCase;

class LibrosControllerTest extends TestCase
{
    public function test_update_method_updates_libro_correctly(){
        $user = User::factory()->create();
        $libro = Libro::factory()->create();
        $nuevosDatos = [
            'titulo' => '1984',
            'editorial' => 'Nueva Editorial',
            'pub' => 2022,
            'genero' => 'Nuevo género',
            'numpag' => 123,
            'idioma' => 'Inglés',
            'cantidad' => 12
        ];
        $response = $this->put(route('libro.update', ['libro' => $libro->id]), $nuevosDatos);
        $response->assertRedirect(route('libro.index'))
            ->assertSessionHas('status', 'Libro actualizado correctamente');
        $this->assertDatabaseHas('libros', $nuevosDatos);
    }
}
