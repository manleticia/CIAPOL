<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\Logs;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use App\Models\TaxeEntreprise;
use App\Imports\EntrepriseImport;
use App\Exports\EntreprisesExport;
// use App\Imports\EntrepriseImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        // dd($entreprises);
        $module = "Module Entreprise  ";
        $action = "A consulter la listes des entreprises";
        Logs::saveLog($module, $action);
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
        $module = "Module Entreprise  ";
        $action = "A consulter la page importations des fichiers excel pour les entreprises ";
        Logs::saveLog($module, $action);
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
                // dd($row);
                if ($this->ligneEstVide($row)) {
                    break; // Sort de la boucle si la ligne est vide
                }

                try {
                    // Conversion des dates si nécessaire (double vérification)

                    $telephone = isset($row['contact']) ? str_replace(' ', '', $row['contact']) : null;
                    $montantNettoye = preg_replace('/[^0-9.]/', '', $row['montant_net_a_payer']);
                    // Gestion des numéros multiples séparés par /
                    $telephones = [];
                    if ($telephone && strpos($telephone, '/') !== false) {
                        $telephones = explode('/', $telephone);
                        $telephone = trim($telephones[0]); // On conserve le premier numéro comme téléphone principal
                        $telephone2 = isset($telephones[1]) ? trim($telephones[1]) : null;
                    } else {
                        $telephone2 = null;
                    }
                    $existe = Entreprise::where('raison_sociale', $row['raison_sociale'])
                        ->where('telephone', $telephone)
                        ->where('inspection', $row['inspection_de'])
                        // ->orWhere('telephone_2', $telephone2)
                        ->first();

                    if ($existe) {
                        $taxeExistante = TaxeEntreprise::where('entreprise_id', $existe->id)
                            ->where('periode', $row['periode'])
                            ->where('numero_titre_facture', $row['titre_n_n_de_la_facture'])
                            ->where('localisation', $row['situation_geographique'])
                            ->where('montant', $montantNettoye)
                            ->first();
                        if (empty($taxeExistante)) {
                            TaxeEntreprise::create([
                                'administrateur_id' => Auth::user()->administrateur->id,
                                'entreprise_id' => $existe->id,
                                'montant' => $montantNettoye ?? null,
                                'localisation' => $row['situation_geographique'] ?? null,
                                'numero_titre_facture' => $row['titre_n_n_de_la_facture'] ?? null,
                                'periode' => $row['periode'] ?? null,
                                'status' => 2,

                            ]);
                            $compteur++;
                        } else {
                            $lignesIgnorées++;
                            // $erreurs[] = "Ligne $numLigne : Entreprise existe déjà pour cette année";
                        }
                        continue;
                    } else {

                        $nouveau = new Entreprise();
                        $nouveau->administrateur_id =  Auth::user()->administrateur->id;
                        $nouveau->raison_sociale = $row['raison_sociale'];
                        $nouveau->inspection = $row['inspection_de'] ?? null;
                        $nouveau->telephone = $telephone ?? null;
                        $nouveau->telephone_2 = $telephone2 ?? null;
                        $nouveau->status = 2;
                        $nouveau->save();
                        TaxeEntreprise::create([
                            'entreprise_id' => $nouveau->id,
                            'administrateur_id' => Auth::user()->administrateur->id,
                            'periode' => $row['periode'] ?? null,
                            'numero_titre_facture' => $row['titre_n_n_de_la_facture'] ?? null,
                            'localisation' => $row['situation_geographique'] ?? null,
                            'montant' => $montantNettoye ?? null,
                            'status' => 2,
                        ]);
                    }
                    $compteur++;
                } catch (\Exception $e) {

                    $erreurs[] = "Ligne " . ($index + 2) . ": " . $e->getMessage();
                    Log::error('Erreur lors de l\'importation pour le matricule ' . $e->getMessage());
                    continue;
                }
            }
            DB::commit();
            $module = "Module Entreprise  ";
            $action = "A charger des fichiers excel pour les entreprises ";
            Logs::saveLog($module, $action);
            return redirect()->route('entreprises.index')
                ->with('success', "Importation réussie. $compteur enregistrements ajoutés.")
                ->withErrors($erreurs);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Erreur lors de l\'importation : ' . $e->getMessage());
            $module = "Module Entreprise  ";
            $action = 'Erreur lors de l\'importation : ' . $e->getMessage();
            Logs::saveLog($module, $action);
            $mess = 'Erreur lors de l\'importation : ' . $e->getMessage();
            $code = 404;
            return view('dashboards.errors.index', compact('code', 'mess'));
        }



        return back()->with('error', 'Erreur lors de l\'upload.');
    }


    private function ligneEstVide($row)
    {
        foreach ($row as $value) {
            if (!empty($value) && $value !== null && $value !== '') {
                return false;
            }
        }
        return true;
    }





    public function exportExcel()
    {
        return Excel::download(new EntreprisesExport, 'entreprises.xlsx');
    }

    public function exportPdf()
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', '300'); 

        $entreprises = Entreprise::all();
        $pas = 1;
        $libelle = 'liste des Entreprises';
        $pdf = PDF::loadView('dashboards.entreprise.pdf', compact('entreprises', 'libelle', 'pas'));
        return $pdf->download('entreprise.pdf');
    }
}
