<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use App\Models\TaxeEntreprise;
// use App\Imports\EntrepriseImport;
use App\Imports\EntrepriseImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreEntrepriseRequest;
use App\Http\Requests\UpdateEntrepriseRequest;

class EntrepriseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $entreprises = Entreprise::all();
        return view('dashboards.entreprise.index', compact('entreprises'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEntrepriseRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Entreprise $entreprise)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Entreprise $entreprise)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEntrepriseRequest $request, Entreprise $entreprise)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entreprise $entreprise)
    {
        //
    }




    // views d'importation de fichier excel
    public function import()
    {
        return view('dashboards.entreprise.importe');
    }

    private function parseDate($dateValue)
    {
        // Si c'est déjà un objet Carbon ou DateTime, on le retourne tel quel
        if ($dateValue instanceof \DateTimeInterface) {
            return Carbon::instance($dateValue);
        }

        // Si c'est un nombre Excel (style 45477)
        if (is_numeric($dateValue)) {
            try {
                return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($dateValue));
            } catch (\Exception $e) {
                return null;
            }
        }

        // Si c'est une chaîne de caractères
        if (is_string($dateValue)) {
            try {
                // Essayer le format j/m/Y (23/12/2021)
                if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $dateValue)) {
                    return Carbon::createFromFormat('d/m/Y', $dateValue);
                }

                // Essayer le format Y-m-d (2021-12-23)
                if (preg_match('/^\d{4}-\d{1,2}-\d{1,2}$/', $dateValue)) {
                    return Carbon::parse($dateValue);
                }
            } catch (\Exception $e) {
                Log::error("Erreur de parsing de date : {$dateValue} - " . $e->getMessage());
                return null;
            }
        }

        return null;
    }
    private function convertToInteger($value)
    {
        if (is_null($value)) return 0;
        if (is_int($value)) return $value;

        // Si c'est une formule Excel
        if (str_starts_with($value, '=')) {
            return 0; // ou une valeur par défaut
        }

        // Supprime les caractères non numériques
        $cleaned = preg_replace('/[^0-9]/', '', $value);
        return $cleaned !== '' ? (int)$cleaned : 0;
    }

    public function traitementImportationExcel(Request $request)
    {
        // Validation
        $request->validate([
            'excel_file' => 'required|file|mimes:xls,xlsx|max:5120' // 5MB max
        ]);


        try {
            DB::beginTransaction();

            $data = Excel::toCollection(new EntrepriseImport(), $request->file('excel_file'));
            if ($data->isEmpty() || $data[0]->isEmpty()) {
                return redirect()->back()->withInput();
            }
            // dd($data[0] );

            $erreurs = [];
            $compteur = 0;
            $lignesIgnorées = 0;
            foreach ($data[0] as $index => $row) {

                $numLigne = $index + 2;

                try {
                    // Conversion des dates si nécessaire (double vérification)


                    $dateDepot = $this->parseDate($row['date_de_depot']);
                    $dateLimite = $this->parseDate($row['date_limite_de_payement']);

                    $nbTaxesNonPayees = $this->convertToInteger($row['nb_de_taxes_deposees_non_payees'] ?? 0);
                    // $telephone = isset($row['telephone']) ? str_replace(' ', '', $row['telephone']) : null;
                    // if (!is_int($nbTaxesNonPayees)) {
                    //     throw new \Exception("Valeur invalide pour 'nb_de_taxes_deposees_non_payees': " . $row['nb_de_taxes_deposees_non_payees']);
                    // }

                    $telephone = isset($row['telephone']) ? str_replace(' ', '', $row['telephone']) : null;

                    // Gestion des numéros multiples séparés par /
                    $telephones = [];
                    if ($telephone && strpos($telephone, '/') !== false) {
                        $telephones = explode('/', $telephone);
                        $telephone = trim($telephones[0]); // On conserve le premier numéro comme téléphone principal
                        $telephone2 = isset($telephones[1]) ? trim($telephones[1]) : null;
                    } else {
                        $telephone2 = null;
                    }



                    if (!$dateDepot || !$dateLimite) {
                        throw new \Exception("Format de date invalide pour la ligne " . ($index + 2));
                    }

                    //  dd($row , $dateDepot, $dateLimite);
                    // $raison_social = $row['raison_sociale'] ?? null;
                    // $inspection = $row['inspection'] ?? null;
                    // verifier si l'entreprise existe déjà
                    // $existe = Entreprise::where('raison_sociale', $row['raison_sociale'])
                    //     ->orWhere('secteur_numero_rapport', $row['secteur_n_de_rapport'])
                    //     ->first();
                    // if ($existe->exists()) {
                    //     // Pour cet exemple, nous allons l'ignorer
                    //     $tab = TaxeEntreprise::where('entreprise_id', $existe->id)
                    //         ->where('annee', $row['annee'])
                    //         ->first();
                    //     if (empty($tab)) {
                    //         // L'entreprise existe mais pas pour cette année, on peut continuer
                    //         $taxes = new TaxeEntreprise();
                    //         $taxes->entreprise_id = $existe->id;
                    //         $taxes->montant = $row['montant'] ?? null;
                    //         $taxes->localisation = $row['localisation'] ?? null;
                    //         $taxes->annee = $row['annee'] ?? null;
                    //         $taxes->save();
                    //     }

                    //     continue;
                    // }

                    $existe = Entreprise::where('raison_sociale', $row['raison_sociale'])
                        ->orWhere('secteur_numero_rapport', $row['secteur_n_de_rapport'])
                        ->where('telephone',$telephone )
                        ->where('telephone_2',$telephone2 )
                        ->first();

                    if ($existe) {
                        $taxeExistante = TaxeEntreprise::where('entreprise_id', $existe->id)
                             ->where('semestre_depose', $row['semestre_depose'])
                             ->where('annee', $row['annee'])
                             ->where('localisation', $row['localisation'])
                             ->where('annee_depot_taxe', $row['annee_de_depot_de_la_taxe'])
                             ->where('date_depot', $dateDepot)
                             ->where('montant', $row['montant'])
                            ->where('date_limite_payement', $dateLimite)
                            ->first();

                        if (empty($taxeExistante)) {
                            TaxeEntreprise::create([
                                'entreprise_id' => $existe->id,
                                'montant' => $row['montant'] ?? null,
                                'localisation' => $row['localisation'] ?? null,
                                'annee' => $row['annee'] ?? null,
                                'annee_depot_taxe' => $row['annee_de_depot_de_la_taxe'] ?? null,
                                'semestre_depose' => $row['semestre_depose'] ?? null,
                                'date_depot' => $dateDepot ?? null,
                                'date_limite_payement' => $dateLimite ?? null,
                                'status' => 2,
                            ]);
                            $compteur++;
                        } else {
                            $lignesIgnorées++;
                            // $erreurs[] = "Ligne $numLigne : Entreprise existe déjà pour cette année";
                        }
                        continue;
                    } else {


                        // creation de

                        $nouveau = new Entreprise();
                        $nouveau->raison_sociale = $row['raison_sociale'];
                        $nouveau->secteur_numero_rapport = $row['secteur_n_de_rapport'] ?? null;
                        $nouveau->inspection = $row['inspection'] ?? null;
                        $nouveau->agent_programme = $row['agent_programme'] ?? null;
                        $nouveau->numero_ligne = $row['n_ligne'] ?? null;
                        $nouveau->lieu_de_depot = $row['lieu_de_depot'] ?? null;
                        $nouveau->telephone = $telephone ?? null;
                        $nouveau->telephone_2 = $telephone2 ?? null;


                        // $nouveau->annee = $row['annee'] ?? null;

                        $nouveau->nb_taxes_deposees = $row['nb_de_taxes_deposees'] ?? null;
                        $nouveau->nb_taxes_deposees_payees = $row['nb_de_taxes_deposees_payees'] ?? null;
                        $nouveau->nb_taxes_deposees_non_payees = $nbTaxesNonPayees  ?? null;
                        $nouveau->status = 2;
                        // $nouveau->montant = $row['montant'] ?? null;

                        $nouveau->save();

                        TaxeEntreprise::create([
                            'entreprise_id' => $nouveau->id,
                            'montant' => $row['montant'] ?? null,
                            'localisation' => $row['localisation'] ?? null,
                            'annee' => $row['annee'] ?? null,
                            'annee_depot_taxe' => $row['annee_de_depot_de_la_taxe'] ?? null,
                            'date_depot' => $dateDepot ?? null,
                            'date_limite_payement' => $dateLimite ?? null,
                            'semestre_depose' => $row['semestre_depose'] ?? null,
                            'status' => 2,
                        ]);
                    }
                    $compteur++;
                } catch (\Exception $e) {

                    $erreurs[] = "Ligne " . ($index + 2) . ": " . $e->getMessage();
                    Log::error('Erreur lors de l\'importation pour le matricule ' . $e->getMessage());
                    continue;

                    // Log::error('Erreur lors de l\'importation : ' . implode(', ', $erreurs));
                }
            }
            // dd($data[0] );
            DB::commit();

            return redirect()->route('entreprises.index')
                ->with('success', "Importation réussie. $compteur enregistrements ajoutés.")
                ->withErrors($erreurs);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Erreur lors de l\'importation : ' . $e->getMessage());
            return redirect()->back();
        }



        return back()->with('error', 'Erreur lors de l\'upload.');
    }
}
