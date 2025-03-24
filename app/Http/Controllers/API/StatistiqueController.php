<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AnnonceService;
use App\Services\CandidatureService;

class StatistiqueController extends Controller
{
    protected $annonceService;
    protected $candidatureService;

    public function __construct(AnnonceService $annonceService, CandidatureService $candidatureService)
    {
        $this->annonceService = $annonceService;
        $this->candidatureService = $candidatureService;
    }

    public function statistiquesAdmin()
    {
        $nombreAnnonces = $this->annonceService->NombreAnnonces();
        $nombreCandidatures = $this->candidatureService->NombreCandidatures();
        $repartitionCandidatures = $this->candidatureService->CandidaturesStatut();

        return response()->json([
            'nombre_annonces' => $nombreAnnonces,
            'nombre_candidatures' => $nombreCandidatures,
            'repartition_candidatures' => $repartitionCandidatures,
        ]);
    }
}

// public function statistiquesAdmin()
// {
//     // Assuming you want to gather statistics for the entire application or admin-level data
//     $nombreAnnonces = $this->annonceService->NombreAnnoncesAdmin();
//     $nombreCandidatures = $this->candidatureService->NombreCandidaturesAdmin();
//     $repartitionCandidatures = $this->candidatureService->CandidaturesStatutAdmin();

//     return response()->json([
//         'nombre_annonces' => $nombreAnnonces,
//         'nombre_candidatures' => $nombreCandidatures,
//         'repartition_candidatures' => $repartitionCandidatures,
//     ]);
// }
