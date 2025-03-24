<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Candidatures;
use App\Models\Annonce;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CandidatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_postuler_annonce()
    {
        $annonce = Annonce::factory()->create();
        $candidat = User::factory()->create();

        $response = $this->postJson('/api/candidatures', [
            'annonce_id' => $annonce->id,
            'candidat_id' => $candidat->id,
            'cv_path' => '/storage/cvs/cv.pdf',
            'lettre_motivation_path' => '/storage/lettres/lettre.pdf',
        ]);

        $response->assertStatus(201)
                 ->assertJson(['annonce_id' => $annonce->id]);
    }

    public function test_recuperer_candidatures_pour_annonce()
    {
        $annonce = Annonce::factory()->create();
        Candidatures::factory()->count(2)->create(['annonce_id' => $annonce->id]);

        $response = $this->getJson("/api/annonces/{$annonce->id}/candidatures");

        $response->assertStatus(200)
                 ->assertJsonCount(2);
    }
}