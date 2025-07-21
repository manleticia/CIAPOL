<?php

use App\Models\PaiementInitial;
use Illuminate\Support\Facades\File;

function appelApiEmail()
{
    $exe = 'REEL';
    $exe = 'LOCAL';
    if ($exe == 'REEL') {
        return "https://mailtremo.paysecurehub.com/api/sendemail";
    } else {
        return "http://mailtremo.paysecurehub.com/api/sendemail";
    }
}
function lienApi()
{
    $exe = 'REEL';
    $exe = 'LOCAL';
    if ($exe == 'REEL') {
        return "https://rest-airtime.paysecurehub.com/api/payhub-ws/build-away";
    } else {
        return "http://rest-airtime.paysecurehub.com/api/payhub-ws/build-away";
    }
}

function MerchantId()
{
    return 'llnal6ched';
}
function ApiKey()
{
    return 'shk_nDgSnvDpGa9ZEvtruZzxpO7gaSfP9qOJCfyh';
}

function messageBrut(array $tableauDeChaines)
{
    $chainefinale = '';
    // Parcourir le tableau et afficher chaque élément
    foreach ($tableauDeChaines as $chaine) {
        $chainefinale .= $chaine . "\n";
    }
    return $chainefinale;
}
function dateFr1($date)
{
    // Configuration de la locale en français
    setlocale(LC_TIME, 'fr_FR.UTF-8', 'fr_FR', 'fr', 'fra');

    // Vérifie le format attendu (Y-m-d)
    $dateTime = DateTime::createFromFormat('Y-m-d', $date);
    if (!$dateTime) {
        $dateTime = DateTime::createFromFormat('d/m/Y', $date);
    }

    if ($dateTime) {
        $timestamp = $dateTime->getTimestamp();
        return strftime('%A %d %B %Y', $timestamp);
    }

    return 'Date invalide';
}


function genereCodePaiement($length = 10)
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
        $existingCode = PaiementInitial::where('codePaiement', $randomString)->exists();

        $attempt++;

        if ($attempt > $maxAttempts) {
            throw new \Exception("Impossible de générer un code unique après $maxAttempts tentatives.");
        }
    } while ($existingCode);

    return $randomString;
}


function genererMotDePasse($longueur = 10)
{
    // Ensemble de caractères possibles
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+';

    // Mélange et sélection aléatoire
    return substr(str_shuffle(str_repeat($alphabet, ceil($longueur / strlen($alphabet)))), 0, $longueur);
}



function urlSite()
{
    $exe = 'REEL';
    $exe = 'LOCAL';
    if ($exe == 'REEL') {
        return "https://www.mafacture.ciapol-ci.com/";
    } else {
        return "http://127.0.0.1:8000/";
    }
}

if (!function_exists('delete_file')) {
    function delete_file($url)
    {
        if (File::exists(public_path($url))) {
            File::delete(public_path($url));
        }
    }
}

function getIp()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}


function extraireMontantEntier($montantAvecDevise)
{
    $montantNet = preg_replace('/[^0-9.]/', '', $montantAvecDevise);
    return (int) floatval($montantNet);
}

function dateDuJourEnFrancais()
{
    setlocale(LC_TIME, 'fr_FR.UTF-8'); // Pour Linux/macOS
    // setlocale(LC_TIME, 'french');   // Pour Windows si nécessaire

    return ucfirst(strftime('%A %d %B %Y'));
}
