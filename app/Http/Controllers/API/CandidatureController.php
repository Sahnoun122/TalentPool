<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CandidatureService;

class CandidatureController extends Controller
{
    protected $candidatureService;

    public function __construct(CandidatureService $candidatureService)
    {
        $this->candidatureService = $candidatureService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'annonce_id' => 'required|exists:annonces,id',
            'candidat_id' => 'required|exists:candidats,id',
            'cv_path' => 'required|string',
            'lettre_motivation' => 'required|string',
        ]);

        $candidature = $this->candidatureService->postuler($request->all());
        return response()->json($candidature, 201);
    }

    public function index(int $annonceId)
    {
        $candidatures = $this->candidatureService->filtrerCandidatures($annonceId);
        return response()->json($candidatures);
    }

    public function destroy(int $id)
    {
        $this->candidatureService->retirerCandidature($id);
        return response()->json(null, 204);
    }
}