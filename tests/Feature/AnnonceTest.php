<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Annonce;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnnonceTest extends TestCase
{
    use RefreshDatabase;

    public function test_creer_annonce()
    {
        $recruteur = User::factory()->create();

        $response = $this->postJson('/api/annonces', [
            'titre' => 'Développeuse',
            'description' => 'Description de l\'annonce',
            'localisation' => 'ksar el kebir',
            'salaire' => 45000,
            'recruteur_id' => $recruteur->id,
        ]);

        $response->assertStatus(201)
                 ->assertJson(['titre' => 'Développeusel']);
    }

    public function test_recuperer_annonces()
    {
        Annonce::factory()->count(3)->create();

        $response = $this->getJson('/api/annonces');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }
}
