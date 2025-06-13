<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Inscrit;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use App\Models\Administrateur;
use App\Models\PaiementInitial;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use App\Http\Requests\AdministrateurLoginRequest;

class HomeController extends Controller
{
    // page d'accueil
    public function index()
    {
        return view('vitrines.index');
    }

    // pahge de connexion
    public function login()
    {
        $title = "Connexion";
        return view('vitrines.login', compact('title'));
    }

    // page d'inscription
    public function inscription()
    {
        $title = "Inscription";
        return view('vitrines.inscriptions', compact('title'));
    }

    public function storeInscription(Request $request)
    {
        // Logique pour traiter l'inscription
        $request->validate([
            'libelle' => 'required|string|max:255',
            'ancien_libelle' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:inscrits,email',
            'telephone' => 'required|string|max:15',
            'nombre_installation' => 'required|integer|min:1',
        ]);
        // Enregistrement de l'inscription
        // $inscrit = new Inscrit();
        // dd($request->all());
        $tel = $request->telephone;
        $verifi = Entreprise::where('telephone', $tel)
            ->orWhere('telephone_2', $tel)
            ->first();
        // dd($request->all(), $verifi);

        if ($verifi) {
            // return back()->withErrors(['telephone' => 'Ce numéro de téléphone est déjà utilisé.']);
            $codeInscription = $this->generateCodeInscrption();
            $inscrit = Inscrit::create([
                'entreprise_id' => $verifi->id,
                'libelle' => $request->libelle,
                'ancien_libelle' => $request->ancien_libelle,
                'email' => $request->email,
                'telephone' => $tel,
                'codeConfirmation' => $codeInscription,
                'nombre_installation' => $request->nombre_installation,
            ]);


            // envoyer un email de confirmation

            $lienDeValidation = URL::signedRoute(
                'accessCreat',
                ['codeInscription' => $codeInscription]
            );

            $sujet = "confirmation de votre inscription";
            $message = "  Salut !, " . $inscrit->libelle . "<br>
                            Merci pour la première étape de votre inscription . <br> Veuillez cliquer sur le boutton ci-dessous pour finaliser votre inscription et creer votre acces . !<br>
                            <div style='margin-top:3px; margin-bottom:3px;  text-align:center;'>
                            <a href=" . $lienDeValidation . " class='bouton'> POURSUIVRE</a> <br>
                            </div>
                                   Merci d'utiliser notre plateforme! <br>
                            Si vous rencontrez des problèmes avec votre compte, n'hésitez pas à nous contacter.
                                    ";

            $url = appelApiEmail();
            $template = View::make('email.index', ['contenumess' => $message])->render();
            $data = [
                'provider' => 'CIAPOL <info@mail-taseti.com>',
                "key_rsa" => 're_2i7H3Ynf_KRVm9VwTsrwrfF8isCBYvyyE',
                "destination" => $inscrit->email,
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
                    // $module = "Envoyer de Mail a la creation Mutualiste";
                    // $action = "Echec d'envoyer de mail  : $message";
                    // Logs::saveLog($module, $action);
                } else {
                    // $module = "Envoyer de Mail a la creation Mutualiste";
                    // $action = "Email envoyer avec success   : $mutualiste->nom , $mutualiste->prenom sur son email  $mutualiste->email";
                    // Logs::saveLog($module, $action);
                }
            } else {
                Log::error("Erreur lors de l'envoi de l'email. Statut API : " . $retourAPI->status());
            }

            return redirect()->route('inscriptionVitrine.success', ['codeInscription' => $codeInscription])->with('success', 'Inscription réussie pour une entreprise existante.');

            Log::info('Inscription traitée pour une entreprise existante', ['entreprise_id' => $verifi->id, 'inscrit_id' => $inscrit->id]);
        }


        // if($request->tel)
        return back()->withErrors(['telephone' => 'Ce numéro de téléphone n\'est pas associé à une entreprise existante. Veuillez contacter l\'administration.']);

        // return redirect()->route('login')->with('success', 'Inscription réussie. Veuillez vous connecter.');
    }


    public function pageresultatsInscription($codeInscription)
    {
        $inscrit = Inscrit::where('codeConfirmation', $codeInscription)->first();
        return view('vitrines.resultatsInscription', compact('inscrit'));
    }



    public function validationAcces($codeInscription)
    {
        // dd($codeInscription);

        $inscrit = Inscrit::where('codeConfirmation', $codeInscription)->first();
        if (empty($inscrit)) {
            return redirect()->route('acceuil')->with('error', 'Code d\'inscription invalide ou expiré.');
        }
        $entreprise = Entreprise::where('id', $inscrit->entreprise_id)->first();
        return view('vitrines.formulaireAcces', compact('inscrit', 'entreprise'));
    }

    // traiment creation d'acces entreprise
    public function traitAcceEntreprise(Request $request)
    {
        $request->validate([
            'entreprise_id' => 'required|integer|exists:entreprises,id',
            'inscrit_id' => 'required|integer|exists:inscrits,id',
            'raison_sociale' => 'required|string|max:255',
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
            $entreprise = Entreprise::where('id', $request->entreprise_id)->first();
            $inscrit = Inscrit::find($request->inscrit_id);
            // dd(Inscrit::all());
            // dd($request->all(),'ici',$entreprise,$inscrit);
            // Création de l'utilisateur
            $user = User::create([
                'name' => $request->raison_sociale,
                'contact' => $request->telephone,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            // Assigner le rôle entreprise
            $user->assignRole('entreprise');

            // Mettre à jour l'entreprise avec l'ID de l'utilisateur
            $entreprise->user_id = $user->id;
            $entreprise->status = 1;
            $entreprise->save();

            // Mettre à jour l'inscription avec le code de confirmation
            $inscrit->codeConfirmation = null; // ou un autre code si nécessaire
            $inscrit->save();

            Log::info('Accès créé pour l\'entreprise', ['entreprise_id' => $entreprise->id, 'user_id' => $user->id]);

            return redirect()->route('pageConnexion')->with('success', 'Accès créé avec succès. Veuillez vous connecter.');
        } catch (\Exception $e) {
            // dd($request->all());
            Log::error('Erreur lors de la création de l\'accès', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Une erreur technique est survenue. Veuillez réessayer.');
        }
    }





    public function connexionAdministrateur(AdministrateurLoginRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();

            // dd($user);
            if (!$user) {
                Log::warning('Tentative de connexion avec email inexistant', ['email' => $request->email]);
                return back()->withInput()->withErrors(['email' => 'Identifiants incorrects.']);
            }

            if (!password_verify($request->password, $user->password)) {
                Log::warning('Tentative de connexion avec mot de passe incorrect', ['user_id' => $user->id]);
                return back()->withInput()->withErrors(['password' => 'Mot de passe incorrect.']);
            }

            Auth::login($user);
            Log::info('Utilisateur connecté', ['user_id' => $user->id]);

            // Vérification des rôles avec journalisation
            if ($user->hasRole('super-administrateur') || $user->hasRole('administrateur')) {
                Log::info('Accès administrateur autorisé', ['user_id' => $user->id]);

                if ($user->administrateur) {
                    $user->administrateur->update(['disponibilite' => 'en ligne']);
                    return redirect()->route('dashboard');
                }

                Log::error('Relation administrateur manquante', ['user_id' => $user->id]);
                Auth::logout();
                return back()->withErrors(['error' => 'Profil administrateur incomplet.']);
            }

            if ($user->hasRole('entreprise')) {
                Log::info('Accès entreprise autorisé', ['user_id' => $user->id]);

                return redirect()->route('espaceClient.index');
            }

            // Si aucun rôle valide
            Log::warning('Tentative de connexion sans rôle approprié', ['user_id' => $user->id]);
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('connexion')->withErrors(['role' => 'Accès non autorisé.']);
        } catch (\Exception $e) {
            Log::error('Erreur de connexion', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withInput()->withErrors(['error' => 'Une erreur technique est survenue. Veuillez réessayer.']);
        }
    }


    private function generateCodeInscrption($length = 10)
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
            $existingCode = Inscrit::where('codeConfirmation', $randomString)->exists();

            $attempt++;

            if ($attempt > $maxAttempts) {
                throw new \Exception("Impossible de générer un code unique après $maxAttempts tentatives.");
            }
        } while ($existingCode);

        return $randomString;
    }



    // page retour paiement
    public function retourPaiement($codePaiement)
    {
        $paiement = PaiementInitial::where('codePaiement', $codePaiement)->first();
        $code = 0;
        $mess = "";
        if ($paiement->status == 1) {
            $code = 200;
            $mess = $Paiement->message_retour ?? "effectué avec succès";
        } else {
            $code = 500;

            $mess = ' Paiement échoué. Si votre compte a été débité, nous vous prions' .
                ' de contacter le support avec la reference: ' . $paiement->codePaiement;
        }
        return view('vitrines.resutltatPay', compact('code', 'mess', 'paiement'));
    }


    // recu de paiement
    public function recuPaiement($codePaiement)
    {
        $paiement = PaiementInitial::where('codePaiement', $codePaiement)->first();
        $infos = Entreprise::where('id', $paiement->entreprise_id)->first();
        // dd($codePaiement,$paiement,$infos);
        return view('vitrines.recu', compact('infos', 'paiement'));
    }
}
