<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Services\AnnonceService;
use Illuminate\Http\Request;
// use Illuminate\Http\;



class AnnonceController extends Controller
{
    protected $annonceService;

    public function __construct(AnnonceService $annonceService)
    {
        $this->annonceService = $annonceService;
    }

    public function index()
    {
        $annonces = $this->annonceService->recupererAnnonces();
        return response()->json($annonces);
    }

    public function store(Request $request)
    {

        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'localisation' => 'required|string|max:255',
            'salaire' => 'required|numeric',
            'recruteur_id' => 'required|exists:recruteurs,id',
        ]);

        $annonce = $this->annonceService->creerAnnonce($request->all());
        return response()->json($annonce, 201);
    }
    public function update(Request $request, int $id)
    {
        $request->validate([
            'titre' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'localisation' => 'sometimes|string|max:255',
            'salaire' => 'sometimes|numeric',
        ]);

        $annonce = $this->annonceService->mettreAJourAnnonce($id, $request->all());
        return response()->json($annonce);
    }

    public function destroy(int $id)
    {
        $this->annonceService->supprimerAnnonce($id);
        return response()->json(null, 204);
    }
}