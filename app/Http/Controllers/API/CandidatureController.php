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
            'annonce_id' => 'required|integer',  
            'candidat_id' => 'required|integer', 
            'cv_path' => 'required|string',
            'lettre_motivation_path' => 'required|string',
        ]);

        $candidature = $this->candidatureService->postuler($request->all());
        return response()->json($candidature, 201);
    }

    public function index( $annonceId)
    {
        $candidatures = $this->candidatureService->filtrerCandidatures($annonceId);
        return response()->json($candidatures);
    }

    public function destroy( $id)
    {
        $this->candidatureService->retirerCandidature($id);
        return response()->json(null, 204);
    }

    public function modifierStatut(Request $request, $id)
    {
        $request->validate([
            'statut' => 'required',
        ]);

        $candidature = $this->candidatureService->mettreStatut($id, $request->statut);
        return response()->json($candidature);
    }
}
