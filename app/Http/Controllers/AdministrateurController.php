<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Logs;
use App\Models\User;
use App\Models\Inscrit;
use Illuminate\Http\Request;
use App\Models\Administrateur;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AdministrateursExport;
use App\Http\Requests\StoreAdministrateurRequest;

use App\Http\Requests\UpdateAdministrateurRequest;

class AdministrateurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $administrateurs = Administrateur::all();
        $ver = auth()->user()->administrateur;
        // dd(Auth::user()->administrateur);
        $administrateurs = Administrateur::where('id', '!=', Administrateur::min('id'))->get();
        $title = 'Liste administrateurs';
        // dd($administrateurs);
        $module = "Module Administrateur ";
        $action = "A  consulter la liste des administrateurs";
        Logs::saveLog($module, $action);
        return view('dashboards.administrateurs.index', compact('administrateurs', 'title', "ver"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $title = 'Liste administrateurs';
        $module = "Module Administrateur ";
        $action = "A  consulter la page de creation d'un administrateur";
        Logs::saveLog($module, $action);
        return view('dashboards.administrateurs.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdministrateurRequest $request)
    {
        //
        try {
            // dd($request->all());
            DB::beginTransaction();
            // assigner un role
            $lien_photo = null;
            $nom_prenoms = $request->nom . ' ' . $request->prenom;
            $mot_passe = genererMotDePasse();
            // Vérifier si le fichier a été téléchargé
            if ($request->hasFile('lien_photo')) {
                $file_name = Carbon::now()->timestamp . '.' . $request->lien_photo->extension();
                $request->lien_photo->storeAs('images-administrateurs/', $file_name);
                $lien_photo = 'src-files/images-administrateurs/' . $file_name;
            }
            // $administrateur
            // $user = User::create([
            //     'name' => $nom_prenoms,
            //     "contact" => $request->contact,
            //     "email" => $request->email,
            //     "password" => Hash::make($mot_passe)
            // ]);
            // if ($request->profil == "administrateur") {
            //     $user->assignRole('administrateur');
            // } else {
            //     $user->assignRole('super-administrateur');
            // }
            // $lienConnexion = urlSite() . 'pageConnexion';
            $codeInscription = $this->generateCodeInscrptionAdmin();
            $adminis = Administrateur::create([
                // "user_id" => $user->id,
                "nom" => $request->nom,
                "prenom" => $request->prenom,
                "contact" =>  $request->contact,
                "email" => $request->email,
                "genre" => $request->genre,
                "adresse" =>  $request->adresse,
                "profil" =>  $request->profil,
                "lien_photo" =>  $lien_photo,
                "codeLiens" => $codeInscription,
                "id_parains" =>  Auth::user()->administrateur->id,
            ]);

            // envoyer mot de passe par email
            $module = "Module Administrateur ";
            $action = "A creer l'administrateur ayant l'id = $adminis->id , nom = $nom_prenoms ";
            Logs::saveLog($module, $action);
            // envoyer de mail pour la page creation
            $lienDeValidation = URL::signedRoute(
                'accesAdminCreat',
                ['codeInscription' => $codeInscription]
            );
            $nom_plateforme = "CIAPOL FACTURE";
            $sujet = "Confirmation de création de votre accès administrateur";
            $message = "
                    <p>Bonjour " . $adminis->prenom . " " . $adminis->nom . ",</p>

                    <p>Nous vous remercions d'avoir initié la création de votre compte administrateur sur notre plateforme.</p>

                    <p>Pour <strong>finaliser votre inscription</strong> et activer votre accès, veuillez cliquer sur le bouton ci-dessous :</p>

                    <div style='text-align:center; margin:25px 0;'>
                        <a href='" . $lienDeValidation . "' style='background-color:#28a745; color:white; padding:12px 30px; text-decoration:none; border-radius:5px; font-weight:bold; font-size:16px;'>
                            ACTIVER MON COMPTE ADMINISTRATEUR
                        </a>
                    </div>
                <p><strong>Informations importantes :</strong></p>
                <ul>
                    <li>Ce lien est valable 24 heures</li>
                    <li>Après activation, vous recevrez vos identifiants par email</li>
                    <li>Conservez ces informations en lieu sûr</li>
                </ul>

                <p>Si vous n'êtes pas à l'origine de cette demande, veuillez ignorer cet email ou nous contacter immédiatement.</p>

                <p>Pour toute assistance, notre équipe support est disponible à l'adresse <a href='mailto:infos@bmi.ci'>infos@bmi.ci</a>.</p>
                <p>contact : +225 2722421619 </p>
                <p>Cordialement,<br>
                <strong>L'équipe technique</strong><br>
                " . $nom_plateforme . "</p>
            ";

            $url = appelApiEmail();
            $template = View::make('email.index', ['contenumess' => $message])->render();
            $data = [
                'provider' => 'CIAPOL <info@mail-taseti.com>',
                "key_rsa" => 're_2i7H3Ynf_KRVm9VwTsrwrfF8isCBYvyyE',
                "destination" => $adminis->email,
                "sujet" => $sujet,
                "message" => $template
            ];

            $retourAPI = Http::post($url, $data);
            $res = $retourAPI->json();

            if ($retourAPI->status() == 200) {
                (int)$code = $res['status'];
                if ($code != 200) {
                    $message = "Une erreur s'est produite " . $code . ", DETAIL: " . messageBrut($res['message']) . " ERR: Inscritpion";
                    // Log::ajoutLOG($message);
                    $module = "Envoyer de Mail a la creation client Entreprise ";
                    $action = "Echec d'envoyer de mail  : $message";
                    Logs::saveLog($module, $action);
                } else {
                    DB::commit();
                    $module = "Envoyer de Mail a la creation client Entreprise";
                    $action = "Email envoyer avec success   : $adminis->nom , $adminis->prenom sur son email  $adminis->email";
                    Logs::saveLog($module, $action);
                }
            } else {
                Log::error("Erreur lors de l'envoi de l'email. Statut API : " . $retourAPI->status());
            }
            return redirect()->route('administrateur.index')->with('success', 'Administrateur Ajouter avec Success');
        } catch (\Throwable $e) {
            //throw $th;
            DB::rollback();
            $module = "Module Administrateur ";
            $action = "Erreur lors de la creation  de l'administrateur : " . $e->getMessage();
            Logs::saveLog($module, $action);
            $mess = "Erreur lors de la creation  de l'administrateur : " . $e->getMessage();
            $code = 404;
            return view('dashboards.errors.index', compact('code', 'mess'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Administrateur $administrateur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $title = " Administratreur Edition";
        $administrateur = Administrateur::find($id);
        $module = "Module Administrateur ";
        $action = "A  consulter la page d'edion de l'administrateur id = $id";
        Logs::saveLog($module, $action);
        return view('dashboards.administrateurs.edit', compact('title', 'administrateur'));
    }



    public function update(UpdateAdministrateurRequest $request,  $id) {}
    public function modifieAdmin(UpdateAdministrateurRequest $request,  $id)
    {
        // dd($request->all());

        try {
            DB::beginTransaction();

            // Vérifier si le fichier a été téléchargé
            $administrateur = Administrateur::find($id);
            // dd($request->all(),$administrateur);
            $lien_photo = null;
            if ($request->hasFile('lien_photo')) {
                // Supprimer l'ancienne photo si elle existe
                if ($administrateur->lien_photo && file_exists(public_path($administrateur->lien_photo))) {
                    unlink(public_path($administrateur->lien_photo));
                }
                // Générer un nom de fichier unique
                $file_name = Carbon::now()->timestamp . '.' . $request->lien_photo->extension();
                // Déplacer le fichier vers le dossier public
                $request->lien_photo->move(public_path('src-files/images-administrateurs'), $file_name);

                // Enregistrer le chemin
                $lien_photo = 'src-files/images-administrateurs/' . $file_name;
            }
            // dd($administrateur->lien_photo);
            // Mettre à jour les autres champs
            $administrateur->update([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'contact' => $request->contact,
                'email' => $request->email,
                'genre' => $request->genre,
                'adresse' => $request->adresse,
                'profil' => $request->profil,
                'lien_photo' => $lien_photo ?? $administrateur->lien_photo,
            ]);
            $module = "Module Administrateur ";
            $action = "A  modifier les information de l'administreur ayant id = $administrateur->id";
            Logs::saveLog($module, $action);

            DB::commit();
            return redirect()->route('administrateur.index')->with('success', 'Administrateur mis à jour avec succès');
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error('Erreur lors de la mise à jour du profil: ' . $th->getMessage());
            $module = "Module Administrateur ";
            $action = "Erreur lors de la mise à jour du profil:" . $th->getMessage();
            Logs::saveLog($module, $action);
            $mess = "Erreur lors de la mise à jour du profil:" . $th->getMessage();
            $code = 404;
            return view('dashboards.errors.index', compact('code', 'mess'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Administrateur $administrateur)
    {
        //
    }

    // profils change acces
    public function profilsAdministrateur()
    {
        $title = "Profil administrateurs";
        $administrateur = auth()->user()->administrateur;
        // dd($administrateur);
        $module = "Module Administrateur ";
        $action = "A  consulte le profils administrateur";
        Logs::saveLog($module, $action);
        return view('dashboards.profils.index', compact('title', 'administrateur'));
    }


    public function miseaJourInfos(UpdateAdministrateurRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            // Vérifier si le fichier a été téléchargé
            $administrateur = Administrateur::find($id);
            // dd($request->all(),$administrateur);
            $lien_photo = null;
            if ($request->hasFile('lien_photo')) {
                // Supprimer l'ancienne photo si elle existe
                if ($administrateur->lien_photo && file_exists(public_path($administrateur->lien_photo))) {
                    unlink(public_path($administrateur->lien_photo));
                }
                // Générer un nom de fichier unique
                $file_name = Carbon::now()->timestamp . '.' . $request->lien_photo->extension();
                // Déplacer le fichier vers le dossier public
                $request->lien_photo->move(public_path('src-files/images-administrateurs'), $file_name);

                // Enregistrer le chemin
                $lien_photo = 'src-files/images-administrateurs/' . $file_name;
            }
            // dd($administrateur->lien_photo);
            // Mettre à jour les autres champs
            $administrateur->update([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'contact' => $request->contact,
                'email' => $request->email,
                'genre' => $request->genre,
                'adresse' => $request->adresse,
                'lien_photo' => $lien_photo ?? $administrateur->lien_photo,
            ]);

            $module = "Module Administrateur ";
            $action = "A modifier le profil administrateur";
            Logs::saveLog($module, $action);

            DB::commit();
            return redirect()->route('profAdmin')->with('success', 'Profil mis à jour avec succès');
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error('Erreur lors de la mise à jour du profil: ' . $th->getMessage());
            $module = "Module Administrateur ";
            $action = "Erreur lors de la mise à jour du profil:" . $th->getMessage();
            Logs::saveLog($module, $action);

            $mess = "Erreur lors de la mise à jour du profil:" . $th->getMessage();
            $code = 404;
            return view('dashboards.errors.index', compact('code', 'mess'));
        }
    }

    public function  accesMotPasse(Request $request, $id)
    {

        try {
            DB::beginTransaction();

            // $request->validated();

            $administrateur = Administrateur::find($id);

            $user = $administrateur->user;
            if ($request->password && $request->password == $request->password_confirmation) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
            DB::commit();
            $module = "Module Administrateur ";
            $action = "A change de mot de passe du l'administrateur id = $id: ";
            Logs::saveLog($module, $action);


            return redirect()->route('profAdmin')->with('success', 'Mot de passe  mise à jour avec succès');
        } catch (\Exception $e) {
            DB::rollback();


            Log::error('Erreur lors de la mise à jour du Mot de passe de l\'administrateur : ' . $e->getMessage());
            $module = "Module Administrateur ";
            $action = 'Erreur lors de la mise à jour du Mot de passe de l\'administrateur : ' . $e->getMessage();
            Logs::saveLog($module, $action);
            $mess = 'Erreur lors de la mise à jour du Mot de passe de l\'administrateur : ' . $e->getMessage();
            $code = 404;
            return view('dashboards.errors.index', compact('code', 'mess'));
        }
    }


    public function desactiveAdmin($id)
    {
        try {
            DB::beginTransaction();
            $administrateur = Administrateur::find($id);
            $administrateur->status = 2;
            $administrateur->save();
            DB::commit();
            $module = "Module Administrateur ";
            $action = "A desactiver l'administrateur id = $id: ";
            Logs::saveLog($module, $action);
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Erreur interne du serveur: ' . $e->getMessage());
            $module = "Module Administrateur ";
            $action = 'Erreur lors de la desactivation d\'un administrateur : ' . $e->getMessage();
            Logs::saveLog($module, $action);
            $mess = 'Erreur lors de la desactivation d\'un administrateur : ' . $e->getMessage();
            $code = 404;
            return view('dashboards.errors.index', compact('code', 'mess'));
        }
    }
    public function reactiveAdmin($id)
    {
        try {
            DB::beginTransaction();
            $administrateur = Administrateur::find($id);
            $userId = $administrateur->user_id;
            $administrateur->status = 1;
            $administrateur->save();
            DB::commit();
            $module = "Module Administrateur ";
            $action = "A reactivier  l'administrateur id = $id: ";
            Logs::saveLog($module, $action);
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Erreur interne du serveur: ' . $e->getMessage());
            $module = "Module Administrateur ";
            $action = 'Erreur lors de la reactivation  d\'un administrateur : ' . $e->getMessage();
            Logs::saveLog($module, $action);
            $mess = 'Erreur lors de la reactivation  d\'un administrateur : ' . $e->getMessage();
            $code = 404;
            return view('dashboards.errors.index', compact('code', 'mess'));
        }
    }
    // page d'envouer creation acces administrateur
    public function validationAccesAdmin($codeInscription)
    {
        $administrateur = Administrateur::where('codeLiens', $codeInscription)->first();
        // dd($administrateur);
        if (empty($administrateur)) {
            $module = "Module Administrateur ";
            $action = "Code de creation acces  invalide ou expiré. pour la creation d'un compte administrateur : code entrer : $codeInscription ";
            Logs::saveLog($module, $action);
            return redirect()->route('acceuil')->with('error', 'Code de creation acces  invalide ou expiré.');
        }
        return view('dashboards.administrateurs.creatAcces', compact('administrateur'));
    }


    private function generateCodeInscrptionAdmin($length = 10)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $maxAttempts = 10; // Nombre maximal de tentatives pour générer un code unique
        $attempt = 0;

        do {
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }

            // Vérifier si le code généré existe déjà en base de données
            $existingCode = Administrateur::where('codeLiens', $randomString)->exists();

            $attempt++;

            if ($attempt > $maxAttempts) {
                throw new \Exception("Impossible de générer un code unique après $maxAttempts tentatives.");
            }
        } while ($existingCode);

        return $randomString;
    }



    public function traitAccesAdministrateur(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'administrateur_id' => 'required|integer|exists:administrateurs,id',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'telephone' => [
                'required',
                'string',
                'regex:/^(\+?[0-9]{8,15})$/',
                'unique:users,contact'
            ],
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $administrateur = Administrateur::where('id', $request->administrateur_id)->first();
            $nom_prenoms = $administrateur->nom . ' ' . $administrateur->prenom;
            $user = User::create([
                'name' => $nom_prenoms,
                'contact' => $request->telephone,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            // Assigner le rôle administrateur
            if ($administrateur->profil == "administrateur") {
                $user->assignRole('administrateur');
            } else {
                $user->assignRole('super-administrateur');
            }

            // Mettre à jour l'entreprise avec l'ID de l'utilisateur
            $administrateur->user_id = $user->id;
            $administrateur->status = 1;
            $administrateur->codeLiens = null; // ou un autre code si nécessaire
            $administrateur->save();

            Log::info('Accès créé pour un administrateur', ['administrateur_id' => $administrateur->id, 'user_id' => $user->id]);

            $module = "Module Administrateur ";
            $action = "Accès créé pour un administrateur', ['administrateur_id' => $administrateur->id, 'user_id' => $user->id]";
            Logs::saveLog($module, $action);
            return redirect()->route('pageConnexion')->with('success', 'Accès créé avec succès. Veuillez vous connecter.');
        } catch (\Exception $e) {
            // dd($request->all());
            Log::error('Erreur lors de la création de l\'accès', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            $module = "Module Administrateur";
            $action = "Erreur lors de la création de l'accès";
            $message = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ];
            Logs::saveLog($module, $action . ' - ' . json_encode($message));
            return back()->with('error', 'Une erreur technique est survenue. Veuillez réessayer.');
        }
    }



    // reinitialiser mot de passe
    public function reinitialiserMotDePasse(Request $request, $id)
    {
        // dd($request->all(),$id);
        try {
            DB::beginTransaction();
            $administrateur = Administrateur::findOrFail($id);
            // dd($administrateur , $administrateur->user->email);
            $codeInscription = $this->generateCodeInscrptionAdmin();
            $administrateur->codeLiens = $codeInscription;
            $administrateur->save();
            // Envoi de l'email avec le nouveau mot de passe
            $lienDeValidation = URL::signedRoute(
                'reinitaccesAdmin',
                ['codeInscription' => $administrateur->codeLiens]
            );
            $nom_plateforme = "CIAPOL FACTURE";
            $sujet = "Réinitialisation de votre mot de passe administrateur";
            $message = "
                        <p>Bonjour " . $administrateur->prenom . " " . $administrateur->nom . ",</p>

                        <p>Votre compte administrateur a été réinitialisé avec succès.</p>

                        <p>Pour définir un <strong>nouveau mot de passe</strong> et accéder à votre espace administrateur, veuillez cliquer sur le bouton ci-dessous :</p>

                        <div style='text-align:center; margin:25px 0;'>
                            <a href='" . $lienDeValidation . "' style='background-color:#007bff; color:white; padding:12px 30px; text-decoration:none; border-radius:5px; font-weight:bold; font-size:16px;'>
                                DÉFINIR MON NOUVEAU MOT DE PASSE
                            </a>
                        </div>

                        <p><strong>Informations importantes :</strong></p>
                        <ul>
                            <li>Ce lien est <strong>valable pendant 48 heures</strong> uniquement.</li>
                            <li>Après ce délai, vous devrez demander une nouvelle réinitialisation.</li>
                            <li>Pour des raisons de sécurité, veillez à choisir un mot de passe fort et à ne pas le partager.</li>
                        </ul>

                        <p>Si vous n'avez pas demandé cette réinitialisation, veuillez ignorer cet e-mail ou contacter notre équipe de support immédiatement.</p>

                        <p>Pour toute assistance, vous pouvez nous écrire à l’adresse suivante :
                            <a href='mailto:infos@bmi.ci'>infos@bmi.ci</a>
                        </p>
                    ";
            $url = appelApiEmail();
            $template = View::make('email.index', ['contenumess' => $message])->render();
            $data = [
                'provider' => 'CIAPOL <info@mail-taseti.com>',
                "key_rsa" => 're_2i7H3Ynf_KRVm9VwTsrwrfF8isCBYvyyE',
                "destination" => $administrateur->email ?? $administrateur->user->email,
                "sujet" => $sujet,
                "message" => $template
            ];
            $retourAPI = Http::post($url, $data);
            $res = $retourAPI->json();

            if ($retourAPI->status() == 200) {
                (int)$code = $res['status'];
                if ($code != 200) {
                    $message = "Une erreur s'est produite " . $code . ", DETAIL: " . messageBrut($res['message']) . " ERR: Inscritpion";
                    // Log::ajoutLOG($message);
                    $module = "Envoyer de Mail a la reinitialisation mot de passe administrateur ";
                    $action = "Echec d'envoyer de mail  : $message";
                    Logs::saveLog($module, $action);
                    $mess = $message;
                    return view('dashboards.errors.index', compact('code', 'mess'));
                } else {
                    DB::commit();
                    $module = "Envoyer de Mail a la reinitialisation mot de passe administrateur";
                    $action = "Email envoyer avec success   : $administrateur->nom , $administrateur->prenom sur son email  $administrateur->email";
                    Logs::saveLog($module, $action);
                    return redirect()->route('administrateur.index')->with('success', 'Mot de passe réinitialisé avec succès. Un email a été envoyé à l\'administrateur avec les nouveaux identifiants.');
                }
            } else {
                Log::error("Erreur lors de l'envoi de l'email. Statut API : " . $retourAPI->status());
                $module = "Module Administrateur ";
                $action = "Erreur lors de l'envoi de l'email. Statut API : " . $retourAPI->status();
                $mess = "Erreur lors de l'envoi de l'email. Statut API : " . $retourAPI->status();
                Logs::saveLog($module, $action);
                $code = 404;
                return view('dashboards.errors.index', compact('code', 'mess'));
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Erreur lors de la réinitialisation du mot de passe de l\'administrateur : ' . $e->getMessage());
            $module = "Module Administrateur ";
            $action = 'Erreur lors de la réinitialisation du mot de passe de l\'administrateur : ' . $e->getMessage();
            Logs::saveLog($module, $action);
            $mess = 'Erreur lors de la réinitialisation du mot de passe de l\'administrateur : ' . $e->getMessage();
            $code = 404;
            return view('dashboards.errors.index', compact('code', 'mess'));
        }
    }

    //
    public function validationAccesRein($codeInscription)
    {
        $administrateur = Administrateur::where('codeLiens', $codeInscription)->first();
        // dd($administrateur);
        if (empty($administrateur)) {
            $module = "Module Administrateur ";
            $action = "Code de reinitialisation  acces  invalide ou expiré. pour la reinitialisation d'un compte administrateur : code entrer : $codeInscription ";
            Logs::saveLog($module, $action);
            return redirect()->route('acceuil')->with('error', 'Code de reinitialisation  acces  invalide ou expiré.');
        }
        return view('dashboards.administrateurs.modifAcces', compact('administrateur'));
    }
    public function reinPassWord(Request $request, $id)
    {
        // dd($request->all(), $id);
        try {
            DB::beginTransaction();
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);

            $administrateur = Administrateur::findOrFail($id);
            $user = $administrateur->user;
            if ($request->password && $request->password == $request->password_confirmation) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
            $administrateur->codeLiens = null; // ou un autre code si nécessaire
            $administrateur->save();
            DB::commit();
            $module = "Module Administrateur ";
            $action = "A reinitialiser le mot de passe de l'administrateur id = $id: ";
            Logs::saveLog($module, $action);
            return redirect()->route('pageConnexion')->with('success', 'Mot de passe réinitialisé avec succès. Veuillez vous connecter.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Erreur lors de la réinitialisation du mot de passe de l\'administrateur : ' . $e->getMessage());
            $module = "Module Administrateur ";
            $action = 'Erreur lors de la réinitialisation du mot de passe de l\'administrateur : ' . $e->getMessage();
            Logs::saveLog($module, $action);
            $mess = 'Erreur lors de la réinitialisation du mot de passe de l\'administrateur : ' . $e->getMessage();
            $code = 404;
            return view('dashboards.errors.index', compact('code', 'mess'));
        }
    }
}
